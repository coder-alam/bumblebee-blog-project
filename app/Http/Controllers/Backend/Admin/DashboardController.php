<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class DashboardController extends Controller {
    public function dashboard() {
        return Inertia::render('Dashboard');
    }
}
