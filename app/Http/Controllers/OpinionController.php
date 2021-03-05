<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Opinion;
use App\Notifications\LikeNotification;
use App\Notifications\MentionNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class OpinionController extends Controller
{
    public function index(Request $request)
    {
        $timeline = Opinion::whereIn('user_id', Auth::user()->following()->get()->push(Auth::user())->pluck('id'))
            ->with('user')
            ->withCount('likes')
            ->with('parent.user')
            ->withcount(['likes as like' => function ($q) {
                return $q->where('user_id', Auth::id());
            }])
            ->withCount('replies')
            ->latest()
            ->paginate();

        if ($request->wantsJson()) {
            return $timeline;
        }

        return Inertia::render('Home', [
            'timeline' => $timeline
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'parent_id' => ['nullable', 'numeric'],
            'opinion' => ['required', 'string'],
        ]);

        $opinion = Auth::user()->opinions()->create([
            'parent_id' => $request->parent_id,
            'opinion' => $request->opinion,
        ]);

        preg_match_all('/data-id="(\d+)"/', $request->opinion, $mentions);

        $mentions = array_unique($mentions[1]);

        foreach($mentions as $user) {
            if ($user != Auth::user()->id) {
                User::find($user)->notify(new MentionNotification($opinion, Auth::user()));
            }
        }

        return redirect()->back();
    }

    public function like(Opinion $opinion)
    {
        if (Auth::user()->likes()->find($opinion)) {
            Auth::user()->likes()->detach($opinion);
        } else {
            Auth::user()->likes()->attach($opinion);

            $opinion->user->notify(new LikeNotification($opinion, Auth::user()));
        }

        return redirect()->back();
    }

    public function show(Opinion $opinion, Request $request)
    {
        $replies = $opinion->replies()
            ->withCount('likes')
            ->withcount(['likes as like' => function ($q) {
                return $q->where('user_id', Auth::id());
            }])
            ->withCount('replies')
            ->with('user')
            ->paginate();

        if ($request->wantsJson()) {
            return $replies;
        }

        return Inertia::render('Opinion', [
            'user' => User::find($opinion->user_id),
            'opinion' => Opinion::where('id', '=', $opinion->id)
                ->withCount('likes')
                ->withcount(['likes as like' => function ($q) {
                    return $q->where('user_id', Auth::id());
                }])
                ->withCount('replies')
                ->with('parent.user')
                ->with('user')
                ->first(),
            'replies' => $replies
        ]);
    }

    public function destroy(Request $request, Opinion $opinion)
    {
        if ($opinion->user_id !== Auth::id()) {
            return abort(403);
        }

        DB::table('notifications')->whereIn('data->opinion->id', $opinion->replies()->pluck('id'))->delete();
        DB::table('notifications')->where('data->opinion->id', $opinion->id)->delete();

        $opinion->delete();

        preg_match('/\/opinion\/(\d+)/', $request->server('HTTP_REFERER'), $id);

        if (count($id) === 0 || $this->checkOpinion($id[1])) {
            return redirect()->back();
        } else {
            return redirect()->route('home');
        }
    }

    public function checkOpinion($id)
    {
        return Opinion::where('id', $id)->count() > 0;
    }
}
