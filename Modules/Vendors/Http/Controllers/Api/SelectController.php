<?php

namespace Modules\Vendors\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;
use Modules\Vendors\Entities\Vendor;
use Modules\Vendors\Http\Filters\SelectFilter;
use Modules\Vendors\Transformers\VendorSelectResource;
use Modules\Dashboard\Transformers\DashboardCardsResource;
use Modules\Dashboard\Transformers\DashboardChartsResource;
class SelectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param SelectFilter $filter
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function vendors()
    {
        $vendors = Vendor::get();

        return VendorSelectResource::collection($vendors);
    }

    public function getCards(Vendor $vendor)
    {
        // start cards
        $data['ordersCount'] = $vendor->orders()->completed()->count();
        $data['todayOrdersCount'] = $vendor->orders()->completed()->whereDate('created_at', Carbon::today())->count();
        $data['totalSales'] = $vendor->orders()->completed()->sum('total');
        $data['todayTotalSales'] = $vendor->orders()->completed()->whereDate('created_at', Carbon::today())->sum('total');
        $data['averageOrders'] = $vendor->orders()->completed()->avg('total');
        $data['todayAverageOrders'] = $vendor->orders()->completed()->whereDate('created_at', Carbon::today())->avg('total');
        // end cards

        $data['orders'] = $vendor->orders()->distinct()
            ->select(DB::raw('count(*) as total'), DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as created_date'))
            ->where('created_at', '>=', DB::raw('DATE(NOW()) - INTERVAL 7 DAY'))->groupBy('created_date')->limit(7)->get();

        $data['sales'] = $vendor->orders()->distinct()
            ->select(DB::raw('sum(total) as total'), DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as created_date'))
            ->where('created_at', '>=', DB::raw('DATE(NOW()) - INTERVAL 7 DAY'))->groupBy('created_date')->limit(7)->get();

        $data['average'] = $vendor->orders()->distinct()
            ->select(DB::raw('round(AVG(total),0) as average'), DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as created_date'))
            ->where('created_at', '>=', DB::raw('DATE(NOW()) - INTERVAL 7 DAY'))->groupBy('created_date')->limit(7)->get();
        // end charts

        return new DashboardCardsResource($data);
    }

    public function getCharts(Vendor $vendor)
    {
        $data['orders'] = $vendor->orders->distinct()
            ->select(DB::raw('count(*) as total'), DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as created_date'))
            ->where('created_at', '>=', DB::raw('DATE(NOW()) - INTERVAL 7 DAY'))->groupBy('created_date')->limit(7)->get();

        $data['sales'] = $vendor->orders->distinct()
            ->select(DB::raw('sum(total) as total'), DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as created_date'))
            ->where('created_at', '>=', DB::raw('DATE(NOW()) - INTERVAL 7 DAY'))->groupBy('created_date')->limit(7)->get();

        $data['average'] = $vendor->orders->distinct()
            ->select(DB::raw('round(AVG(total),0) as average'), DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as created_date'))
            ->where('created_at', '>=', DB::raw('DATE(NOW()) - INTERVAL 7 DAY'))->groupBy('created_date')->limit(7)->get();

        return new DashboardChartsResource($data);
    }

    public function filterCards(Request $request,Vendor $vendor)
    {
        $start = $request->start;
        $end = $request->end;
        $data['ordersCount'] = $vendor->orders->whereBetween('created_at', [$start, $end])->count();
        $data['totalSales'] = $vendor->orders->whereBetween('created_at', [$start, $end])->sum('total');
        $data['averageOrders'] = $vendor->orders->whereBetween('created_at', [$start, $end])->avg('total');

        $data['orders'] = $vendor->orders->distinct()
            ->select(DB::raw('count(*) as total'), DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as created_date'))
            ->whereBetween('created_at', [$start, $end])->groupBy('created_date')->limit(7)->get();

        $data['sales'] = $vendor->orders->distinct()
            ->select(DB::raw('sum(total) as total'), DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as created_date'))
            ->whereBetween('created_at', [$start, $end])->groupBy('created_date')->limit(7)->get();

        $data['average'] = $vendor->orders->distinct()
            ->select(DB::raw('round(AVG(total),0) as average'), DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as created_date'))
            ->whereBetween('created_at', [$start, $end])->groupBy('created_date')->limit(7)->get();
        return new DashboardCardsResource($data);
    }
}
