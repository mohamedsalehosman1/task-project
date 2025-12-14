<?php

namespace Modules\Advertisements\Http\Controllers;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Modules\Advertisements\Entities\Advertisement;
use Modules\Advertisements\Http\Filters\SelectFilter;
use Modules\Advertisements\Transformers\AdvertisementSelectResource;
use Modules\Advertisements\Transformers\AdvertisementsResource;
use Modules\Support\Traits\ApiTrait;

class SelectController extends Controller
{
    use ApiTrait;


    public function index()
    {
        $data = AdvertisementsResource::collection(Advertisement::validVendor()->active()->expire(false)->get());
        return $this->sendResponse($data, __('Data Found'));
    }

    public function show(Advertisement $advertisement)
    {
        return $this->sendResponse(new AdvertisementsResource($advertisement), __('Data Found'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param SelectFilter $filter
     * @return AnonymousResourceCollection
     */
    public function advertisements(SelectFilter $filter)
    {
        $advertisements = Advertisement::filter($filter)->get();

        return AdvertisementSelectResource::collection($advertisements);
    }
}
