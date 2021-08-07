<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Frequency;
use App\Utils\TranslationValidator;

class RoutineRequest extends FormRequest
{
   /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sport' => 'required|integer|exists:athlete_group_sports,id',
            'measure' => 'required|integer|exists:measure_tags,id',
            'regions' => 'required|regions',
            'objective' => 'required|integer|exists:objective_tags,id',
            'level' => 'required|integer|exists:level_tags,id',
            'gender' => 'required|integer|exists:gender_tags,id',
            'age' => 'required|integer|exists:age_tags,id',
            'frequence_default' => 'required|integer|min:' . Frequency::MIN . '|max:' . Frequency::MAX,
            'duration_default' => 'required|integer|min:0|max:24',
            'pubmed_link' => 'url',
        ];
    }

    public function messages()
    {
        return [
            'level.required' => 'Wählen Sie ein Level aus.',
            'level.integer' => 'Wählen Sie ein gültiges Level aus.',
            'level.exists' => 'Wählen Sie ein gültiges Level aus.',
        ];
    }

    /**
     * Adds validation rules for routine translations.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();

        TranslationValidator::add($validator, true);

        return $validator;
    }
}
