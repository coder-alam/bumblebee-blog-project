<?php

namespace App\Http\Controllers\Backend\Admin\Tag;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Tag\TagRequest;
use App\Http\Resources\Admin\Tag\TagResource;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Inertia\Inertia;
use Inertia\Response;

class TagController extends Controller {
    public function index(): Response {
        Inertia::setRootView('admin');
//        return Inertia::render('Admin/Tag/TagIndex', [
//            'tags' => TagResource::collection(Tag::all())->map(function ($tag) {
//                return [
//                    'id' => $tag->id,
//                    'tag_name' => $tag->tag_name,
//                ];
//            }),
//        ]);
        return Inertia::render('Admin/Tag/TagIndex', ['tags' => TagResource::collection(Tag::all())]);
    }

    public function create(): Response {
        Inertia::setRootView('admin');
        return Inertia::render('Admin/Tag/Create');
    }

    public function store(TagRequest $request): RedirectResponse {
//        $request->validate([
//            'tag_name' => 'required|max:255|unique:tags,tag_name',
//        ]);
        $result = Tag::insert([
            'tag_name' => $request->tag_name,
            'created_at' => Carbon::now()
        ]);
        if ($result == true) {
            return to_route('tag.index')->with('success', 'Tag created successfully');
        } else {
            return back()->with('failed', 'Tag created failed',);
        }
    }
}
