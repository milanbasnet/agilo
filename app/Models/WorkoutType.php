<?php

namespace App\Models;

use stdClass;

abstract class WorkoutType
{
    const DYNAMIC_TYPE = 1;

    const STATIC_TYPE = 2;

    public static function values()
    {
        $dynamic = new stdClass();
        $dynamic->value = self::DYNAMIC_TYPE;
        $dynamic->label = 'dynamic';

        $static = new stdClass();
        $static->value = self::STATIC_TYPE;
        $static->label = 'static';

        return array($dynamic, $static);
    }

    public static function label($type) {
        switch ($type) {
            case self::DYNAMIC_TYPE:
                return 'dynamic';
            case self::STATIC_TYPE:
                return 'static';
            default:
                return 'unknown';
        }
    }
}