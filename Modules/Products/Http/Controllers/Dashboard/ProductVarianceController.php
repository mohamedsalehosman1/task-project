<?php

namespace Modules\Products\Http\Controllers\Dashboard;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Modules\Colors\Entities\Color;
use Modules\Products\Entities\Product;
use Modules\Products\Entities\ProductVariance;
use Modules\Products\Http\Requests\ProductVarianceRequest;
use Modules\Products\Repositories\ProductVarianceRepository;
use Modules\Services\Entities\Service;
use Modules\Vendors\Entities\Vendor;

class ProductVarianceController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * @var ProductRepository
     */
    private $repository;

    /**
     * CountryController constructor.
     *
     * @param ProductRepository $repository
     *
     */
    public function __construct(ProductVarianceRepository $repository)
    {
        $this->middleware('permission:read_products')->only(['index']);
        $this->middleware('permission:create_products')->only(['create', 'store']);
        $this->middleware('permission:update_products')->only(['edit', 'update']);
        $this->middleware('permission:delete_products')->only(['destroy']);
        $this->middleware('permission:show_products')->only(['show']);

        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(Product $product)
    {
        $product_variances = $this->repository->all();

        return view('products::product_variances.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(Product $product)
    {
        $colors = Color::listsTranslations("name")->pluck('name', 'id')->toArray();
        return view('products::product_variances.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductVarianceRequest $request
     */
    public function store(ProductVarianceRequest $request)
    {
        $product = $this->repository->create($request->validated());

        flash(trans('products::product_variances.messages.created'))->success();

        return redirect()->route('dashboard.product_variances.index' , $product);
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return View
     */
    public function show(Product $product)
    {
        $product = $this->repository->find($product);

        return view('products::product_variances.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @return View
     *
     */
    public function edit(Product $product , ProductVariance $productVariance)
    {
        if($productVariance->product_id != $product->id){
            return abort(404);
        }

        $colors = Color::listsTranslations("name")->pluck('name', 'id')->toArray();
        return view('products::product_variances.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductVarianceRequest $request
     * @param Product $product
     */
    public function update(ProductVarianceRequest $request, Product $product, ProductVariance $productVariance)
    {
        $productVariance = $this->repository->update($product, $request->validated());

        flash(trans('products::product_variances.messages.updated'))->success();

        return redirect()->route('dashboard.product_variances.index' , $product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     */
    public function destroy(Product $product, ProductVariance $productVariance)
    {
        $exists = $this->canDelete($product);

        if (!$exists) {
            $this->repository->delete($product->id);
        }

        flash(trans('products::product_variances.messages.' . ($exists ? "cant-delete" : "deleted")))->error();

        return redirect()->route('dashboard.product_variances.index' , $product);
    }

    public function canDelete($product)
    {
        return false ;
        // return Price::whereProductId($product->id)->exists();
    }
}
