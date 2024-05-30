<?php

namespace App\Http\Controllers\Backend\Admin\Role;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Tag\TagResource;
use App\Models\Tag;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class RoleController extends Controller {
    public function index(Request $request): Response {
        Inertia::setRootView('admin');
        return Inertia::render('Admin/Role/RoleIndex', ['tags' => TagResource::collection(Tag::all())]);
    }
}
