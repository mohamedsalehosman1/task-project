<?php

namespace Modules\Dashboard\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Modules\Accounts\Entities\Admin;
use Modules\Categories\Entities\Category;
use Modules\Projects\Entities\Project;
use Modules\Settings\Entities\ContactUs;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $title = 'Dashboard';
    $breadcrumbs = ['dashboard.home']; 
        $messages = ContactUs::latest()->take(5)->get();
        // $projects_number = Project::count();
        $admins_number = Admin::count();
        $client_number = Category::count();
        return view('dashboard::index', get_defined_vars());
    }
}
