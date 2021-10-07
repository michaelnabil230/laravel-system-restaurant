<?php
if (!function_exists('setting')) {
    function setting($key, $default = '')
    {
        $setting = collect(cache()->get('setting'))->where('key', $key);

        $setting = $setting->first();
        return $setting ? $setting['value'] : $default;
    }
}
