<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *    title="Storage Application API",
 *    version="1.0.0",
 *    description="Storage API",
 * @OA\Contact(
 *   name="Min",
 *   url="https://www.facebook.com/Min9802/",
 *    email="hotro.minservice@gmail.com",
 * )
 * ),

 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
