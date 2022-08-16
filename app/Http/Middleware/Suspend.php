<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class Suspend
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Get Current URL
        $currentURL = URL::to("/");

        // Get Store Settings & Other Settings
        $store_data = frontStoreID($currentURL);

        // Get Current Front Store ID
        $front_store_id =  $store_data['store_id'];

        // Store Settings
        $store_setting = isset($store_data['store_settings']) ? $store_data['store_settings'] :'';

        // Suspend Permenantly
        $suspend_permanently = isset($store_setting['suspend_permanently']) ? $store_setting['suspend_permanently'] : 'no';

        if($suspend_permanently == 'yes')
        {
            // Suspend For
            $suspend_for = isset($store_setting['suspend_for']) ? $store_setting['suspend_for'] : '';

            if($suspend_for == 'web' || $suspend_for == 'both')
            {
                $today = strtotime(date('Y-m-d'));
                $suspend_time = isset($store_setting['suspend_time']) ? strtotime($store_setting['suspend_time']) : '';

                if(!empty($suspend_time) || $suspend_time != '')
                {
                    if($suspend_time >= $today)
                    {
                        return redirect()->route('suspend');
                    }
                }

            }

        }

        return $next($request);
    }
}
