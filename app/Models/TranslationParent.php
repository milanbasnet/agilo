<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TranslationParent
 * Abstract eloquent model which represents the parent model of a translation.
 *
 * @see Translation
 */
abstract class TranslationParent extends Model
{
    /**
     * Returns the associated translations.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    abstract public function translations();
}
