<?php

namespace Modules\Vendors\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Vendors\Entities\Vendor;
use Modules\Vendors\Repositories\VendorRepository;
use Modules\Vendors\Transformers\VendorDetailsResource;
use Modules\Vendors\Transformers\VendorsBriefResource;
use Modules\Support\Traits\ApiTrait;
use Modules\Vendors\Transformers\VendorSelectResource;

class SelectController extends Controller
{
    use ApiTrait;

    private $repository;

    /**
     * VendorRepository constructor.
     */
    public function __construct(VendorRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the Advertisements.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $vendors = $this->repository->allApi();

        $data = VendorsBriefResource::collection($vendors)->response()->getData(true);
        return $this->sendResponse($data, 'success');
    }

    public function show($id)
    {
        $Vendor = Vendor::findOrFail($id);
        $data = new VendorDetailsResource($Vendor);

        return $this->sendResponse($data, __('Data Found'));
    }


    public function getVendorsBySizeId($id)
    {

        $decodedJsonString = html_entity_decode(Request("session"));
        $decodedData = json_decode($decodedJsonString, true);
        $service_id = data_get($decodedData, "service_id", 1);

        $vendors = Vendor::whereHas("vendorServices", function ($q) use ($id, $service_id) {
            $q->whereServiceId($service_id)->whereHas("prices", function ($qu) use ($id) {
                return $qu->whereSizeId($id);
            });
        })->get();

        if ($vendors) {
            $data = VendorSelectResource::collection($vendors);
            return $this->sendResponse($data, __('Data Found'));
        }
        return $this->sendError(__('No data found'), [], 404);
    }
}
