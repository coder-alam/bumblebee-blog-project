<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller {
    public function index(): Response {
        Inertia::setRootView('admin');
        return Inertia::render('Admin/Dashboard');
    }
}
