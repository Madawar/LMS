<?php

namespace App\Http\Middleware;

use App\Http\Controllers\ProfileController;
use App\Models\Staff;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $staff = Staff::where('pno',Auth::user()->pno)->first();
        if($staff->detailsVerified == 0){
            return redirect()->action([ProfileController::class, 'index']);
        }
        return $next($request);
    }
}
