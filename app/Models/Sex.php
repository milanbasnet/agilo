<?php

namespace App\Models;

use stdClass;

abstract class Sex
{
    const MALE = 1;

    const FEMALE = 2;

    public static function values()
    {
        $male = new stdClass();
        $male->value = self::MALE;
        $male->label = 'male';

        $female = new stdClass();
        $female->value = self::FEMALE;
        $female->label = 'female';

        return array($male, $female);
    }

    public static function label($sex) {
        switch ($sex) {
            case self::MALE:
                return 'male';
            case self::FEMALE:
                return 'female';
            default:
                return 'unknown';
        }
    }
}