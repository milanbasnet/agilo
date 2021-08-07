<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Utils\TranslationValidator;

class WorkoutRequest extends FormRequest
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
        $rules = [
            'image' => 'required|image|mimes:jpeg,png|max:2048',
            'type' => 'required|digits_between:1,2',
            'video' => 'required|file|mimetypes:video/mp4|max:51200|video:codec=h264,max_width=1920,max_height=1080,max_length=40',
            'pace_tag_id'=>'required',
            'level_tag_id'=>'required',
        ];

        switch ($this->method()) {
            case 'PUT':
            case 'PATCH':
            {
                $rules['image'] = 'image|mimes:jpeg,png|max:2048';
                $rules['video'] = 'file|mimetypes:video/mp4|max:51200|video:codec=h264,max_width=1920,max_height=1080,max_length=40';
                break;
            }
            default:break;
        }

        return $rules;
    }

    /**
     * Adds validation rules for workout translations.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();

        TranslationValidator::add($validator);

        return $validator;
    }
}
