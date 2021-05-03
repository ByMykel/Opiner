<?php

namespace App\Http\Controllers;

use App\Http\Requests\createOpinionRequest;
use App\Models\User;
use App\Models\Opinion;
use App\Models\Reopinion;
use App\Notifications\LikeNotification;
use App\Notifications\MentionNotification;
use App\Notifications\ReopinionNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class OpinionController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $opinions = Opinion::whereHas('user', function ($query) use ($user) {
            $query->whereHas('followers', function ($q) use ($user) {
                $q->where('follower_id', $user->id);
            });
        })
            ->orWhere('user_id', $user->id)
            ->with(['user', 'parent.user'])
            ->withCount(['likes', 'replies', 'reopinions'])
            ->withcount(['likes as like' => function ($q) {
                return $q->where('user_id', Auth::id());
            }])
            ->withcount(['reopinions as reopinion' => function ($q) {
                return $q->where('reopinion_user_id', Auth::user()->id);
            }])
            ->get();

        $reopinions = Reopinion::whereHas('reuser', function ($query) use ($user) {
            $query->whereHas('followers', function ($q) use ($user) {
                $q->where('follower_id', $user->id);
            });
        })
            ->orWhere('reopinion_user_id', $user->id)
            ->with(['user', 'parent.user', 'reuser'])
            ->withCount(['likes', 'replies', 'reopinions'])
            ->withcount(['likes as like' => function ($q) {
                return $q->where('user_id', Auth::id());
            }])
            ->withCount(['reopinions as reopinion' => function ($q) {
                return $q->where('reopinion_user_id', Auth::user()->id);
            }])
            ->get();

        $timeline = $this->paginateCollection($opinions->mergeRecursive($reopinions)->sortByDesc('reopinion_created_at'));

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

    public function reopinion(Opinion $opinion)
    {
        $reopinion = Reopinion::where('id', $opinion->id)->where('reopinion_user_id', Auth::user()->id);

        if ($reopinion->first()) {
            $reopinion->delete();
        } else {
            DB::table('reopinions')->insert([
                'id' => $opinion->id,
                'user_id' => $opinion->user->id,
                'reopinion_user_id' => Auth::user()->id,
                'parent_id' => $opinion->parent_id,
                'opinion' => $opinion->opinion,
                'created_at' => $opinion->created_at,
                'updated_at' => $opinion->updated_at,
                'reopinion_created_at' => NOW(),
            ]);

            if (Auth::user()->id !== $opinion->user_id) {
                $opinion->user->notify(new ReopinionNotification($opinion, Auth::user()));
            }
        }

        return redirect()->back();
    }

    public function show(Opinion $opinion, Request $request)
    {
        $opinionData = Opinion::where('id', '=', $opinion->id)
            ->with(['user', 'parent.user'])
            ->withCount(['likes', 'replies', 'reopinions'])
            ->withcount(['likes as like' => function ($q) {
                return $q->where('user_id', Auth::id());
            }])
            ->withcount(['reopinions as reopinion' => function ($q) {
                return $q->where('reopinion_user_id', Auth::user()->id);
            }])
            ->first();

        $replies = $opinion->replies()
            ->with('user')
            ->withCount(['likes', 'replies', 'reopinions'])
            ->withcount(['likes as like' => function ($q) {
                return $q->where('user_id', Auth::id());
            }])
            ->withcount(['reopinions as reopinion' => function ($q) {
                return $q->where('reopinion_user_id', Auth::user()->id);
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

    public function paginateCollection($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (\Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof \Illuminate\Support\Collection ? $items : \Illuminate\Support\Collection::make($items);
        return new \Illuminate\Pagination\LengthAwarePaginator(array_values($items->forPage($page, $perPage)->toArray()), $items->count(), $perPage, $page, $options);
    }
}
