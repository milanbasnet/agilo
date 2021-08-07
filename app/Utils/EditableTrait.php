<?php

namespace App\Utils;


use Auth;

trait EditableTrait
{
    /**
     * Is the current user authorized to edit the current model?
     *
     * @return bool
     */
    public function isEditable()
    {
        return $this->office_id == Auth::user()->office_id;
    }
}