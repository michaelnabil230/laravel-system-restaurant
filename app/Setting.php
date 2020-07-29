<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name', 'logo', 'value_added'
    ];
    protected $appends = ['logo_path'];

    public function getLogoPathAttribute()
    {
        return \Storage::url($this->logo);

    }//end of Logo path attribute


}
