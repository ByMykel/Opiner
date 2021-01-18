<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Opinion;
use App\Notifications\LikeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'opinion' => ['required', 'string', 'max:280'],
        ]);

        Auth::user()->opinions()->create([
            'parent_id' => $request->parent_id,
            'opinion' => $request->opinion,
        ]);

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
}
