<?php

namespace App\Traits;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

trait FactoryTrait
{
    private function randomNull($str1, $str2 = null)
    {
        return mt_rand(0, 2) ? $str1 : $str2;
    }
}
