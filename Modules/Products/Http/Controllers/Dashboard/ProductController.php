<?php

namespace Modules\Products\Http\Controllers\Dashboard;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Modules\Addresses\Entities\Address;
use Modules\Addresses\Entities\Region;
use Modules\Products\Entities\Product;
use Modules\Products\Entities\UserProduct;
use Modules\Products\Http\Requests\ProductRequest;
use Modules\Products\Repositories\ProductRepository;
use Modules\Services\Entities\Service;
use Modules\Vendors\Entities\Vendor;

class ProductController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    private ProductRepository $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->middleware('permission:read_products')->only(['index']);
        $this->middleware('permission:create_products')->only(['create', 'store']);
        $this->middleware('permission:update_products')->only(['edit', 'update']);
        $this->middleware('permission:delete_products')->only(['destroy']);
        $this->middleware('permission:show_products')->only(['show']);

        $this->repository = $repository;
    }


    public function index()
    {
       if (auth()->user()->isVendor()) {
    $products = Product::where('status', 'accepeted')
        ->where('vendor_id', auth()->user()->vendor_id) // جلب منتجات البائع الحالي فقط
        ->with(['service', 'vendor'])
        ->get();
        return view('products::products.index', compact('products'));
}
else{

        $dashboardProducts = Product::where('status', 'accepeted')->with(['service', 'vendor'])->get();
        $mobileProducts = UserProduct::where('status', 'accepeted')->with(['service', 'vendor', 'translations'])->get();

        $allProducts = $dashboardProducts->concat($mobileProducts);

        $perPage = 15;
        $currentPage = request()->get('page', 1);
        $pagedData = $allProducts->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $products = new \Illuminate\Pagination\LengthAwarePaginator(
            $pagedData,
            $allProducts->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }
        return view('products::products.index', compact('products'));
    }

    /**
     * صفحة إنشاء منتج جديد
     */
    public function create()
    {
        $vendors = Vendor::listsTranslations("name")->pluck('name', 'id')->toArray();
        $services = Service::listsTranslations("name")->pluck('name', 'id')->toArray();
        $regions = Region::listsTranslations("name")->pluck('name', 'id');
        $addresses = Address::listsTranslations("name")->pluck('name', 'id');

        return view('products::products.create', get_defined_vars());
    }

    /**
     * تخزين منتج جديد
     */
    public function store(ProductRequest $request)
    {
        DB::beginTransaction();

        try {
            $productData = $request->except(['addresses_ids', 'latitudes', 'longitudes', 'ranges', 'working_hours']);
            $product = $this->repository->createproduct($productData);

            // ربط العناوين
            if ($request->filled('addresses_ids')) {
                foreach ($request->addresses_ids as $addressId) {
                    $product->addresses()->attach($addressId, [
                        'latitude'  => $request->input("latitudes.{$addressId}"),
                        'longitude' => $request->input("longitudes.{$addressId}"),
                        'range'     => $request->input("ranges.{$addressId}"),
                    ]);
                }
            }

            // ربط ساعات العمل
            if ($request->boolean('enable_working_hours')) {
                $days  = $request->input('working_hours.day', []);
                $froms = $request->input('working_hours.from', []);
                $tos   = $request->input('working_hours.to', []);

                foreach ($days as $i => $day) {
                    if (!empty($day) && !empty($froms[$i]) && !empty($tos[$i])) {
                        $product->workingHours()->create([
                            'day'  => $day,
                            'from' => $froms[$i],
                            'to'   => $tos[$i],
                        ]);
                    }
                }
            }

            DB::commit();

            flash(trans('products::products.messages.created'))->success();
            return redirect()->route('dashboard.products.index');

        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);

            flash(__('products::products.messages.create_failed'))->error();
            return back()->withInput();
        }
    }

    /**
     * قبول منتج من لوحة التحكم
     */
    public function accept(Product $product)
    {
        $product->update(['status' => 'accepeted']);
        flash(trans('products::products.messages.accepted'))->success();

        return redirect()->route('requests');
    }

    /**
     * قبول منتج من تطبيق الموبايل
     */
    public function acceptUserProduct(UserProduct $userProduct)
    {
        $userProduct->update(['status' => 'accepeted']);
        flash(trans('products::products.messages.accepted'))->success();

        return redirect()->route('requests');
    }

    /**
     * رفض منتج من لوحة التحكم
     */
    public function reject(Product $product)
    {
        $product->update(['status' => 'rejected']);
        flash(trans('products::products.messages.rejected'))->error();

        return redirect()->route('requests');
    }

    /**
     * رفض منتج من تطبيق الموبايل
     */
    public function rejectUserProduct(UserProduct $userProduct)
    {
        $userProduct->update(['status' => 'rejected']);
        flash(trans('products::products.messages.rejected'))->error();

        return redirect()->route('requests');
    }

    /**
     * عرض الطلبات المعلقة (بانتظار الموافقة)
     */
    public function requests()
    {
           if (auth()->user()->isVendor()) {
    $products = Product::where('status', 'pending')
        ->where('vendor_id', auth()->user()->vendor_id) // جلب منتجات البائع الحالي فقط
        ->with(['service', 'vendor'])
        ->get();
        return view('products::products.requests', compact('products'));
}
        $dashboardProducts = Product::where('status', 'pending')->with(['service', 'vendor'])->get();
        $mobileProducts = UserProduct::where('status', 'pending')->with(['service', 'vendor', 'translations'])->get();

        $allProducts = $dashboardProducts->concat($mobileProducts);

        $perPage = 15;
        $currentPage = request()->get('page', 1);
        $pagedData = $allProducts->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $products = new \Illuminate\Pagination\LengthAwarePaginator(
            $pagedData,
            $allProducts->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('products::products.requests', get_defined_vars());
    }

    /**
     * عرض تفاصيل منتج
     */
    public function show(Product $product)
    {
        $product = $this->repository->find($product);

        return view('products::products.show', compact('product'));
    }

    /**
     * صفحة تعديل منتج
     */
    public function edit(Product $product)
    {
        $regions = Region::listsTranslations("name")->pluck('name', 'id');
        $addresses = Address::listsTranslations("name")->pluck('name', 'id');
        $vendors = Vendor::listsTranslations("name")->pluck('name', 'id')->toArray();
        $services = Service::listsTranslations("name")->pluck('name', 'id')->toArray();

        return view('products::products.edit', get_defined_vars());
    }

    /**
     * تحديث منتج
     */
   public function update(ProductRequest $request, Product $product)
{
    DB::beginTransaction();

    try {
        // تحديث البيانات الأساسية للمنتج
        $productData = $request->except(['addresses_ids', 'latitudes', 'longitudes', 'ranges', 'working_hours']);
        $this->repository->update($product, $productData);

        // تحديث العناوين المرتبطة
        $product->addresses()->detach();

        if ($request->filled('addresses_ids')) {
            foreach ($request->addresses_ids as $addressId) {
                $product->addresses()->attach($addressId, [
                    'latitude'  => $request->input("latitudes.{$addressId}"),
                    'longitude' => $request->input("longitudes.{$addressId}"),
                    'range'     => $request->input("ranges.{$addressId}"),
                ]);
            }
        }

        // تحديث ساعات العمل
        $product->workingHours()->delete();

        if ($request->boolean('enable_working_hours')) {
            $days  = $request->input('working_hours.day', []);
            $froms = $request->input('working_hours.from', []);
            $tos   = $request->input('working_hours.to', []);

            foreach ($days as $i => $day) {
                if (!empty($day) && !empty($froms[$i]) && !empty($tos[$i])) {
                    $product->workingHours()->create([
                        'day'  => $day,
                        'from' => $froms[$i],
                        'to'   => $tos[$i],
                    ]);
                }
            }
        }

        DB::commit();

        flash(trans('products::products.messages.updated'))->success();
        return redirect()->route('dashboard.products.index');
    } catch (\Throwable $e) {
        DB::rollBack();
        report($e);

        flash(__('products::products.messages.update_failed'))->error();
        return back()->withInput();
    }
}

    /**
     * حذف منتج
     */
    public function destroy(Product $product)
    {
        $this->repository->delete($product);

        flash(trans('products::products.messages.deleted'))->error();

        return redirect()->route('dashboard.products.index');
    }
    public function activate(Request $request, Product $product)
    {
        activate($product, $request->status);
        $msg = $product->isActive() ? __("products::products.messages.activated") : __("products::advertisements.messages.deactivated");
        return response()->json([
            'active' => $product->active,
            'msg'    => $msg,
        ], 200);
    }
}
