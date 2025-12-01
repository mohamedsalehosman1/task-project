<?php

namespace Modules\Frontend\Http\Controllers\Api;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Categories\Entities\Category;
use Modules\Employees\Entities\Employee;
use Modules\HowKnow\Entities\Reason;
use Modules\Packages\Entities\Package;
use Modules\Projects\Entities\Project;
use Modules\Services\Entities\Service;
use Modules\Settings\Entities\ContactUs;
use Modules\Support\Traits\ApiTrait;


class FrontendController extends Controller
{
    use ApiTrait;
    /**
     * Display a listing of the resource.
     * @return RedirectResponse
     */
    // public function index()
    // {
    //     $packages = Package::orderBy('rank', 'ASC')->get();
    //     $projects = Project::orderBy('rank', 'ASC')->get();
    //     $team = Employee::orderBy('rank', 'ASC')->get();
    //     $clients = Client::get();
    //     return view('frontend::landing', get_defined_vars());
    // }


    /**
     * Display a listing of the resource.
     * @return RedirectResponse
     */
    public function about()
    {
        // $clients = Client::orderBy('rank', 'ASC')->get();
        $categories = Category::get();
        $reasons = Reason::get();
        $services = Service::orderBy('rank', 'ASC')->get();
        return view('frontend::about', get_defined_vars());
    }

    public function services()
    {
        $services = Service::whereHas('projects')->orderBy('rank', 'ASC')->get();
        return view('frontend::services', get_defined_vars());
    }

    public function project($slug)
    {
        $project = Project::firstWhere('slug', $slug);
        return view('frontend::project', get_defined_vars());
    }

    public function index()
    {
        $packages = Package::orderBy('rank', 'ASC')->get();
        $projects = Project::orderBy('rank', 'ASC')->get();
        $team = Employee::orderBy('rank', 'ASC')->get();
        $categories = Category::get();
        return view('frontend::landing', get_defined_vars());
    }



    /**
     * Display a listing of the resource.
     * @return RedirectResponse
     */
    public function contactPost(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'nullable',
            'message' => 'required',
        ], [
            'name.required' => __('frontend::frontend.name_required'),
            'email.required' => __('frontend::frontend.email_required'),
            'email.email' => __('frontend::frontend.email_email'),
            // 'phone.required' => __('phone is required'),
            'message.required' => __('frontend::frontend.message_required'),
        ]);


        if ($validator->fails()) {
            $firstError = $validator->errors()->first();
            return $this->sendError($firstError);
        }

        $contact = ContactUs::create($request->except('_token'));

        // try {
        //     // send mail to contact
        //     Mail::to($contact->email)->send(new ContactMail($contact->name));
        // } catch (\Exception $e) {
        //     Log::error($e->getMessage());
        // }

        return $this->sendSuccess(__('frontend::frontend.contact_success'));
    }


}
