<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\FollowNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->search) {
            $users = User::where('username', 'LIKE', '%' . $request->search . '%')->paginate();
        } else {
            $users = User::inRandomOrder()
                ->whereNotIn('id', Auth::user()->following()->get()->pluck('id'))
                ->where('id', '!=', Auth::user()->id)
                ->limit(10)
                ->withcount(['followers as follow' => function ($q) {
                    return $q->where('follower_id', Auth::id());
                }])
                ->paginate();
        }

        if ($request->wantsJson()) {
            return $users;
        }

        return Inertia::render('Explore', [
            'users' => $users
        ]);
    }

    public function follow(User $user)
    {
        if (Auth::user()->following()->find($user)) {
            Auth::user()->following()->detach($user);
        } else {
            Auth::user()->following()->attach($user);

            $user->notify(new FollowNotification(Auth::user()));
        }

        return redirect()->back();
    }

    public function show(User $user, Request $request)
    {
        $opinions = $user->opinions()
            ->with('user')
            ->with('parent.user')
            ->withCount('likes')
            ->withcount(['likes as like' => function ($q) {
                return $q->where('user_id', Auth::id());
            }])
            ->withCount('replies')
            ->latest()
            ->paginate();

        if ($request->wantsJson()) {
            return $opinions;
        }

        return Inertia::render('User/User', [
            'user' => User::where('id', $user->id)
                ->withcount('following')
                ->withcount(['followers as follow' => function ($q) {
                    return $q->where('follower_id', Auth::id());
                }])
                ->withcount('followers')
                ->withcount('opinions')
                ->get(),
            'opinions' => $opinions,
            'profile' => $user->id === Auth::user()->id
        ]);
    }

    public function following(User $user, Request $request)
    {
        $following = $user->following()
            ->withcount(['followers as follow' => function ($q) {
                return $q->where('follower_id', Auth::id());
            }])
            ->paginate();

        if ($request->wantsJson()) {
            return $following;
        }

        return Inertia::render('User/Following', [
            'user' => $user,
            'following' => $following
        ]);
    }

    public function followers(User $user, Request $request)
    {
        $followers = $user->followers()
            ->withcount(['followers as follow' => function ($q) {
                return $q->where('follower_id', Auth::id());
            }])
            ->paginate();

        if ($request->wantsJson()) {
            return $followers;
        }
            
        return Inertia::render('User/Followers', [
            'user' => $user,
            'followers' => $followers
        ]);
    }
}
