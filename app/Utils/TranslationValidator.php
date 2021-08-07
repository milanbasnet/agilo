<?php

namespace App\Utils;

use Illuminate\Validation\Validator;
use LaravelLocalization;

/**
 * Class TranslationValidator
 * Adds validation rules to a given {@link Validator}-object for form input fields which are used for translations.
 */
class TranslationValidator
{
    /**
     * Adds validation rules to a given {@link Validator}-object for form input fields which are used for translations.
     *
     * @param \Illuminate\Contracts\Validation\Validator|Validator $validator
     * @param bool $isRoutine
     */
    public static function add(Validator $validator, $isRoutine = false)
    {
        $messages = [];

        foreach (LaravelLocalization::getSupportedLocales() as $languageCode => $locale) {
            $prefix = 'translation.'.$languageCode.'.';
            $language = $locale['native'];

            $messages = static::extendMessages($messages, $language, $prefix, $isRoutine);
            static::extendRules($validator, $languageCode, $prefix, $isRoutine);
        }

        $validator->setCustomMessages($messages);
    }

    /**
     * Extends the given array $messages with validation messages for the given $language.
     *
     * @param $messages
     * @param $language
     * @param $prefix
     *
     * @param bool $isRoutine
     * @return array
     */
    private static function extendMessages($messages, $language, $prefix, $isRoutine)
    {
        if (!$isRoutine) {
            return array_merge($messages, [
                $prefix . 'title.required' => trans('validation.workout_title.required', ['language' => $language]),
                $prefix . 'title_in_app.required' => trans('validation.title_in_app.required', ['language' => $language]),
                $prefix . 'title.max' => trans('validation.workout_title.max', ['language' => $language, 'max' => 50]),
                $prefix . 'title_in_app.max' => trans('validation.title_in_app.max', ['language' => $language, 'max' => 50]),
                $prefix . 'starting_position.required' => trans('validation.starting_position.required', ['language' => $language]),
                $prefix . 'execution.required' => trans('validation.execution.required', ['language' => $language]),
            ]);
        } else {
            return array_merge($messages, [
                $prefix . 'title.required' => trans('validation.title.required', ['language' => $language]),
            ]);
        }
    }

    /**
     * Extends the validation rules of the {@link Validator}-object for the given language.
     * If the given language equals the current locale, the form fields title and description are required.
     * Otherwise the form fields are only required if one of the fields is filled.
     *
     * @param Validator $validator
     * @param $languageCode
     * @param $prefix
     * @param bool $internalExternal
     */
    private static function extendRules(Validator $validator, $languageCode, $prefix, $isRoutine)
    {
        if (!$isRoutine) {
            if ($languageCode === LaravelLocalization::getCurrentLocale()) {
                $validator->addRules([$prefix . 'title' => 'required|max:50']);
                $validator->addRules([$prefix . 'title_in_app'=> 'required|max:50']);
                $validator->addRules([$prefix . 'starting_position'=> 'required']);
                $validator->addRules([$prefix . 'execution'=> 'required']);
            } else {
                $validator->addRules($prefix . 'title', 'max:50');

                $validator->sometimes($prefix . 'title', 'required', function ($input) use ($languageCode) {
                    return strlen($input['translation'][$languageCode]['starting_position']) > 0 || strlen($input['translation'][$languageCode]['execution']) > 0;
                });

                $validator->sometimes($prefix . 'starting_position', 'required', function ($input) use ($languageCode) {
                    return strlen($input['translation'][$languageCode]['title']) > 0 || strlen($input['translation'][$languageCode]['execution']) > 0;
                });

                $validator->sometimes($prefix . 'execution', 'required', function ($input) use ($languageCode) {
                    return strlen($input['translation'][$languageCode]['title']) > 0 || strlen($input['translation'][$languageCode]['starting_position']) > 0;
                });
            }
        } else {
            if ($languageCode === LaravelLocalization::getCurrentLocale()) {
                $validator->addRules([$prefix . 'title'=> 'required']);
            }
        }
    }

    /**
     * Determines if the passed translation.
     *
     * @param $translation
     * @param bool $isRoutine
     *
     * @return bool
     */
    public static function filled($translation, $isRoutine = false)
    {
        if (!$isRoutine) {
            return strlen($translation['title']) > 0 &&
                strlen($translation['title_in_app']) > 0 &&
                strlen($translation['starting_position']) > 0 &&
                strlen($translation['execution']) > 0;
        } else {
            return strlen($translation['title']) > 0;
        }
    }
}
