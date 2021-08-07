<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Translation
 * Abstract eloquent model which represents the translation of a model.
 *
 * @see TranslationParent
 */
abstract class Translation extends Model
{
    /**
     * Returns the corresponding parent.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    abstract public function parent();
}
