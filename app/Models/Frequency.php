<?php

namespace App\Models;

abstract class Frequency
{
    const MIN = 1;

    const MAX = 7;

    public static function label($times) {
        return $times . trans('messages.frequency.label');
    }
}