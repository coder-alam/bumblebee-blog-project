<?php

namespace App\Http\Controllers\Backend\Admin\Permission;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Tag\TagResource;
use App\Models\Tag;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PermissionController extends Controller {
    public function index(Request $request): Response {
        Inertia::setRootView('admin');
        return Inertia::render('Admin/Permission/PermissionIndex', ['tags' => TagResource::collection(Tag::all())]);

    }
}
