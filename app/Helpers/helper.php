<?php
if (!function_exists('setting')) {
    function setting($data)
    {
        return \App\Setting::first()->$data;
    }
}
