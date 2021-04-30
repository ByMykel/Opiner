<?php

namespace App\Http\Controllers;

use App\Http\Requests\createOpinionRequest;
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
        $usersIds = Auth::user()->following()->get()->push(Auth::user())->pluck('id');

        $timeline = Opinion::whereIn('user_id', $usersIds)
            ->with(['user', 'parent.user'])
            ->withCount(['likes', 'replies'])
            ->withcount(['likes as like' => function ($q) {
                return $q->where('user_id', Auth::id());
            }])
            ->latest()
            ->paginate();

        if ($request->wantsJson()) {
            return $timeline;
        }

        return Inertia::render('Home', [
            'timeline' => $timeline
        ]);
    }

    public function store(createOpinionRequest $request)
    {
        $opinion = Auth::user()->opinions()->create([
            'parent_id' => $request->parent_id,
            'opinion' => $request->opinion,
        ]);

        preg_match_all('/data-id="(\d+)"/', $request->opinion, $mentions);

        $mentions = array_unique($mentions[1]);

        foreach ($mentions as $user) {
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

            if (Auth::user()->id !== $opinion->user->id) {
                $opinion->user->notify(new LikeNotification($opinion, Auth::user()));
            }
        }

        return redirect()->back();
    }

    public function show(Opinion $opinion, Request $request)
    {
        $opinionData = Opinion::where('id', '=', $opinion->id)
            ->with(['user', 'parent.user'])
            ->withCount(['likes', 'replies'])
            ->withcount(['likes as like' => function ($q) {
                return $q->where('user_id', Auth::id());
            }])
            ->first();

        $replies = $opinion->replies()
            ->with('user')
            ->withCount(['likes', 'replies'])
            ->withcount(['likes as like' => function ($q) {
                return $q->where('user_id', Auth::id());
            }])
            ->paginate();

        if ($request->wantsJson()) {
            return $replies;
        }

        return Inertia::render('Opinion', [
            'opinion' => $opinionData,
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

        if (count($id) === 0 || Opinion::checkOpinion($id[1])) {
            return redirect()->back();
        } else {
            return redirect()->route('home');
        }
    }
}
