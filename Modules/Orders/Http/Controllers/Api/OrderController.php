<?php
namespace Modules\Orders\Http\Controllers\Api;

use App\Enums\OrderStatusEnum;
use App\Services\PaymentGateways\MyfatoorahService;
use Auth;
use DB;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Modules\Carts\Entities\CartItem;
use Modules\Orders\Entities\Builders\OrderBuilder;
use Modules\Orders\Entities\Order;
use Modules\Orders\Entities\OrderVendor;
use Modules\Orders\Http\Requests\OrderRequest;
use Modules\Orders\Repositories\OrderRepository;
use Modules\Orders\Transformers\OrderBreifResource;
use Modules\Orders\Transformers\UserOrdersResource;
use Modules\Products\Entities\Product;
use Modules\Support\Traits\ApiTrait;

class OrderController extends Controller
{
    use AuthorizesRequests, ValidatesRequests, ApiTrait;

    /**
     * @var OrderRepository
     */
    private OrderRepository $repository;
    protected $myfatoorahService;
    /**
     * OrderController constructor.
     * @param OrderRepository $repository
     */
    public function __construct(OrderRepository $repository, MyfatoorahService $myfatoorahService)
    {
        $this->repository        = $repository;
        $this->myfatoorahService = $myfatoorahService;
    }

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index()
    {

        $orders = $this->repository->customer();
        $data   = OrderBreifResource::collection($orders)->response()->getData(true);
        return $this->sendResponse($data, 'success');
    }

    public function store(OrderRequest $request)
    {
        $user      = auth()->user();
        $paymentId = $request->validated()['payment_id'];
        DB::beginTransaction();

        try {

            $order = (new OrderBuilder)
                ->setUser($user)
                ->setCartItems($request->products)
                ->calculateTotals()
                ->buildOrder($request->validated())
                ->attachTaxes()
                ->attachVendorsAndItems()
                ->build();
            foreach ($request->products as $productData) {

                $product = Product::find($productData['id']);

                if (! $product) {
                    continue;
                }

                $vendor = $product->vendor;

                if (! $vendor) {
                    continue;
                }

                $orderVendor = OrderVendor::firstOrCreate([
                    'order_id'  => $order->id,
                    'vendor_id' => $vendor->id,
                ]);

                $order->vendorItems()->create([
                    'order_vendor_id'    => $orderVendor->id ?? null,
                    'product_id'         => $productData['id'],
                    'quantity'           => $productData['quantity'],
                    'price'              => $productData['price'],
                    'total'              => $productData['quantity'] * $productData['price'],
                    'delivery_latitude'  => $productData['delivery_latitude'] ?? null,
                    'delivery_longitude' => $productData['delivery_longitude'] ?? null,
                    'delivery_date'      => $productData['delivery_date'] ?? null,
                    'delivery_time'      => $productData['delivery_time'] ?? null,
                    'notes'              => $productData['notes'] ?? null,
                ]);
            }

            if ($paymentId == 1) {
                $paymentDetails = $this->myfatoorahService->processPayment($order, $paymentId);
                if (! $paymentDetails) {
                    throw new Exception(trans("orders::validation.payment_processing_failed"));
                }

                $order->update(["invoice_id" => $paymentDetails['invoiceId']]);

                DB::commit();
                return $this->sendResponse($paymentDetails, 'success');
            }

            CartItem::whereIn('product_id', collect($request->products)->pluck('id'))
                ->where('cart_id', $user->cart->id)
                ->delete();

            $order->update(["status" => OrderStatusEnum::Paid->value]);
            DB::commit();
            return $this->sendResponse(new OrderBreifResource($order), 'success');

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    /**
     * @param Order $order
     * @return JsonResponse
     */
    public function show(Order $order): JsonResponse
    {
        $data = new UserOrdersResource($order);
        return $this->sendResponse($data, 'success');
    }
}
