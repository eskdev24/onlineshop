<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

if (!function_exists('settings')) {
    /**
     * Get settings value or default.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function settings($key, $default = null)
    {
        try {
            // Cache settings for 24 hours to avoid redundant DB hits
            $settings = Cache::remember('buyvia_site_settings', 86400, function () {
                return Setting::pluck('value', 'key')->toArray();
            });

            return $settings[$key] ?? $default;
        } catch (\Exception $e) {
            return $default;
        }
    }
}
