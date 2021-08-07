<?php

namespace App\Utils;

use Illuminate\Database\Eloquent\Model;
use Session;

/**
 * Class SessionUtil
 * Provides methods to receive values from the session.
 */
class SessionUtil
{
    /**
     * Returns the old value stored in the session for a given prefix and key or
     * if an old value does not exist, the method returns the value of $model->$key.
     *
     * @param Model|null $model
     * @param $prefix
     * @param $key
     *
     * @return string
     */
    public static function old(Model $model = null, $prefix, $key)
    {
        $default = '';

        if (!is_null($model)) {
            $default = $model->$key;
        }

        return old($prefix.$key, $default);
    }

    /**
     * Determines the value of a checkbox.
     *
     * @param $key
     * @param $value
     *
     * @return bool
     */
    public static function checked($key, $value)
    {
        if (count(Session::getOldInput()) == 0) {
            return $value;
        }

        return Session::hasOldInput($key);
    }
}
