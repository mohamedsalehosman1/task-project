<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Support\Traits\ApiTrait;

class isWasher
{
    use ApiTrait;

    public function handle(Request $request, Closure $next)
    {
        if (get_class(auth()->user()) == "Modules\Accounts\Entities\Washer") {
            return $next($request);
        }
        return $this->sendError(__('You do not have permission to access.'), [], '401');
    }
}
