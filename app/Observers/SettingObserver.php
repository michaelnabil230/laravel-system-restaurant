<?php

namespace App\Observers;

use App\Models\Setting;

class SettingObserver
{
    public function creating(Setting $setting)
    {
        $this->putCache($setting);
    }

    private function putCache($setting)
    {
        $setting = collect(cache()->get('setting'))->push([
            'id' => $setting->id,
            'key' => $setting->key,
            'value' => $setting->value,
        ])
            ->values()
            ->toArray();
        cache()->rememberForever('setting', $setting);
    }

    public function updating(Setting $setting)
    {
        $this->forgetCache($setting);
        $this->putCache($setting);
    }

    private function forgetCache($setting)
    {
        $setting = collect(cache()->get('setting'))->firstWhere('id', $setting->getOriginal('id'));
        $setting = collect(cache()->get('setting'))->filter(function ($value) use ($setting) {
            return $value != $setting;
        })
            ->values()
            ->toArray();
        cache()->forget('setting');
        cache()->rememberForever('setting', $setting);
    }

    public function deleted(Setting $setting)
    {
        $this->forgetCache($setting);
    }
}
