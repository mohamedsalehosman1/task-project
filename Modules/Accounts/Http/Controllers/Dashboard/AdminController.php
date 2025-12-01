<?php

namespace Modules\Accounts\Http\Controllers\Dashboard;

// use Doctrine\DBAL\Query\QueryException;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Modules\Accounts\Entities\Admin;
use Modules\Accounts\Http\Requests\AdminRequest;
use Modules\Accounts\Repositories\AdminRepository;
use Illuminate\Database\QueryException;

class AdminController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * The repository instance.
     *
     * @var AdminRepository
     */
    private $repository;

    /**
     * AdminController constructor.
     *
     * @param AdminRepository $repository
     */
    public function __construct(AdminRepository $repository)
    {
        $this->middleware('permission:read_admins')->only(['index']);
        $this->middleware('permission:create_admins')->only(['create', 'store']);
        $this->middleware('permission:update_admins')->only(['edit', 'update']);
        $this->middleware('permission:delete_admins')->only(['destroy']);
        $this->middleware('permission:show_admins')->only(['show']);
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $admins = $this->repository->all();

        return view('accounts::admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('accounts::admins.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AdminRequest $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function store(AdminRequest $request)
    {
        $admin = $this->repository->create($request->allWithHashedPassword());

        flash(trans('accounts::admins.messages.created'))->success();

        return redirect()->route('dashboard.admins.show', $admin);
    }

    /**
     * Display the specified resource.
     *
     * @param Admin $admin
     * @return Application|Factory|View
     */
    public function show(Admin $admin)
    {
        $admin = $this->repository->find($admin);

        return view('accounts::admins.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Admin $admin
     * @return Application|Factory|View
     */
    public function edit(Admin $admin)
    {
        $admin = $this->repository->find($admin);

        return view('accounts::admins.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AdminRequest $request
     * @param Admin $admin
     * @return RedirectResponse
     * @throws Exception
     */

public function update(AdminRequest $request, Admin $admin)
{
    try {
        $admin = $this->repository->update($admin, $request->allWithHashedPassword());

        flash(trans('accounts::admins.messages.updated'))->success();

        return redirect()->route('dashboard.admins.show', $admin);
    }
    catch (QueryException $e) {
    $message = $e->getMessage();

    if ($e->errorInfo[1] == 1062) {
        if (str_contains($message, 'users_phone_unique')) {
            flash('رقم الهاتف مستخدم بالفعل.')->error();
        } elseif (str_contains($message, 'users_email_unique')) {
            flash('البريد الإلكتروني مستخدم بالفعل.')->error();
        } else {
            flash('يوجد مدخل مكرر (مثل رقم الهاتف أو البريد الإلكتروني).')->error();
        }

        return redirect()->back()->withInput();
    }

    flash('حدث خطأ غير متوقع.')->error();
    return redirect()->back()->withInput();
}
}

    /**
     * Remove the specified resource from storage.
     *
     * @param Admin $admin
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Admin $admin)
    {
        if (auth()->user()->is($admin)) {
            abort(403, 'cannot be deleted due to that your account.');
        }

        $this->repository->delete($admin);

        flash(trans('accounts::admins.messages.deleted'))->error();

        return redirect()->route('dashboard.admins.index');
    }

    /**
     * @param Admin $admin
     * @return RedirectResponse
     * @throws Exception
     */
    public function block(Admin $admin)
    {
        $this->repository->block($admin);

        flash(trans('accounts::admins.messages.blocked'))->success();

        return redirect()->route('dashboard.admins.show', $admin);
    }

    /**
     * @param Admin $admin
     * @return RedirectResponse
     * @throws Exception
     */
    public function unblock(Admin $admin)
    {
        $this->repository->unblock($admin);

        flash(trans('accounts::admins.messages.unblocked'))->success();

        return redirect()->route('dashboard.admins.show', $admin);
    }
}
