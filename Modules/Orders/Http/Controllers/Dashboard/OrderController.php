<?php

namespace Modules\Orders\Http\Controllers\Dashboard;

use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Modules\Orders\Entities\Order;
use Modules\Orders\Events\UpdateOrderStatusEvent;
use Modules\Orders\Repositories\OrderRepository;

class OrderController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * @var OrderRepository
     */
    private OrderRepository $repository;

    /**
     * OrderController constructor.
     * @param OrderRepository $repository
     */
    public function __construct(OrderRepository $repository)
    {
        $this->middleware('permission:read_orders')->only(['index']);
        $this->middleware('permission:create_orders')->only(['create', 'store']);
        $this->middleware('permission:update_orders')->only(['edit', 'update']);
        $this->middleware('permission:delete_orders')->only(['destroy']);
        $this->middleware(['permission:show_orders'])->only(['show', 'invoice']);
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     * @return Factory|View
     */
    public function index()
    {
        $orders = $this->repository->all();

        return view('orders::orders.index', compact('orders'));
    }

    /**
     * Show the specified resource.
     * @param Order $order
     * @return Factory|View
     */
    public function show($order)
    {
        $order = $this->repository->find($order);
        return view('orders::orders.show', compact('order'));
    }

    /**
     * Remove the specified resource from storage.
     * @param Order $order
     * @return RedirectResponse
     */
    public function destroy(Order $order): RedirectResponse
    {
        $this->repository->delete($order);

        flash(trans('orders::orders.messages.deleted'))->error();

        return redirect()->route('dashboard.orders.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @param Order $order
     * @return RedirectResponse
     */
    public function status(Request $request, Order $order): RedirectResponse
    {
        $order->update($request->only('status'));

        event(new UpdateOrderStatusEvent($order));

        flash(trans('orders::orders.messages.status'))->success();

        return redirect()->route('dashboard.orders.show', $order);
    }


    /**
     * Show the specified resource.
     * @param Order $order
     * @return Factory|View
     */
    public function invoice($id)
    {
        $order = $this->repository->find($id);
        return view('orders::orders.invoice', compact('order'));
    }

    /**
     * Show the specified resource.
     * @param Order $order
     * @return Factory|View
     */
    public function printReceipt($id)
    {
        $order = $this->repository->find($id);

        return view('orders::orders.invoice_receipt', compact('order'));
    }

    public function payForm()

    {
        return view('orders::orders.pay-form');
    }
}
