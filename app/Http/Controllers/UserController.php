<?php

namespace App\Http\Controllers;

use App\Models\Opinion;
use App\Models\Reopinion;
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
            $users = User::where('username', 'LIKE', '%' . $request->search . '%')
                ->withcount(['followers as follow' => function ($q) {
                    return $q->where('follower_id', Auth::id());
                }])
                ->paginate();
        } else {
            $users = User::inRandomOrder()
                ->whereNotIn('id', Auth::user()->following()->get()->pluck('id'))
                ->where('id', '!=', Auth::user()->id)
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

    public function mention(Request $request)
    {
        $users = [];

        if ($request->search) {
            $users = User::where('username', 'LIKE', '%' . $request->search . '%')
                ->withcount(['followers as follow' => function ($q) {
                    return $q->where('follower_id', Auth::id());
                }])
                ->limit(5)
                ->get();
        }

        return $users;
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
        $userData = User::where('id', $user->id)
            ->withcount(['following', 'followers', 'opinions'])
            ->withcount(['followers as follow' => function ($q) {
                return $q->where('follower_id', Auth::id());
            }])
            ->get();

        $opinions = Opinion::whereHas('user', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
            ->with(['user', 'parent.user'])
            ->withCount(['likes', 'replies', 'reopinions'])
            ->withcount(['likes as like' => function ($q) {
                return $q->where('user_id', Auth::id());
            }])
            ->withcount(['reopinions as reopinion' => function ($q) {
                return $q->where('reopinion_user_id', Auth::user()->id);
            }])
            ->get();

        $reopinions = Reopinion::where('reopinion_user_id', $user->id)

            ->with(['user', 'parent.user', 'reuser'])
            ->withCount(['likes', 'replies', 'reopinions'])
            ->withcount(['likes as like' => function ($q) {
                return $q->where('user_id', Auth::id());
            }])
            ->withcount(['reopinions as reopinion' => function ($q) {
                return $q->where('reopinion_user_id', Auth::user()->id);
            }])
            ->get();

        $timeline = $this->paginateCollection($opinions->mergeRecursive($reopinions)->sortByDesc('reopinion_created_at'));

        if ($request->wantsJson()) {
            return $timeline;
        }

        return Inertia::render('User/User', [
            'user' => $userData,
            'opinions' => $timeline,
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

    public function paginateCollection($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (\Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof \Illuminate\Support\Collection ? $items : \Illuminate\Support\Collection::make($items);
        return new \Illuminate\Pagination\LengthAwarePaginator(array_values($items->forPage($page, $perPage)->toArray()), $items->count(), $perPage, $page, $options);
    }
}
