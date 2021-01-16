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
    public function index()
    {
        return Inertia::render('Home', [
            'timeline' => Opinion::whereIn('user_id', Auth::user()->following()->get()->push(Auth::user())->pluck('id'))
                ->with('user')
                ->withCount('likes')
                ->with('parent.user')
                ->withcount(['likes as like' => function ($q) {
                    return $q->where('user_id', Auth::id());
                }])
                ->withCount('replies')
                ->latest()
                ->get()->each(function ($q) {
                    return $q->updated_at->diffForHumans();
                })
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

    public function show(Opinion $opinion)
    {
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
            'replies' => $opinion->replies()
                ->withCount('likes')
                ->withcount(['likes as like' => function ($q) {
                    return $q->where('user_id', Auth::id());
                }])
                ->withCount('replies')
                ->with('user')
                ->get(),
        ]);
    }
}
