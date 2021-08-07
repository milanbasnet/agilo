<?php

namespace App\Utils;

use App\Models\Translation;
use App\Models\TranslationParent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use LaravelLocalization;

/**
 * Class TranslationUtil
 * Provides utility methods for translations of workouts and workout routines.
 */
class TranslationUtil
{
    /**
     * Closure for eager loading of translations.
     *
     * @var callable
     */
    private static $closure;

    /**
     * Returns a closure which can be used for eager loading of translations, filtered by the current locale.
     *
     * @return callable Closure
     */
    public static function closure()
    {
        if (is_null(static::$closure)) {
            static::$closure = function ($query) {
                $query->where('language_code', LaravelLocalization::getCurrentLocale());
            };
        }

        return static::$closure;
    }

    /**
     * Creates translations for each translation given in the request.
     *
     * @param Request           $request
     * @param TranslationParent $parent
     * @param $class string The specific class which is used for creation
     */
    public static function create(Request $request, TranslationParent $parent, $class)
    {
        foreach ($request->get('translation') as $languageCode => $input) {
            static::createSingle($class, $parent, $input, $languageCode);
        }
    }

    /**
     * Creates a translation using the given data.
     *
     * @param $class string The specific class which is used for creation
     * @param $parent
     * @param $data
     * @param $languageCode
     */
    private static function createSingle($class, $parent, $data, $languageCode)
    {
        $translation = new $class($data);
        $translation->language_code = $languageCode;
        $translation->parent()->associate($parent);
        $translation->save();
    }

    /**
     * Updates the translations of a given parent using the request data.
     * If a translation does not exists in the database, a new translation will be created.
     * If the request data for a translation is empty, the corresponding translation will
     * be removed from the database.
     *
     * @param Request           $request
     * @param TranslationParent $parent
     * @param $class string The specific class which is used for creation
     * @param bool $isRoutine
     */
    public static function update(Request $request, TranslationParent $parent, $class, $isRoutine = false)
    {
        $translations = $parent->translations;

        foreach ($request->get('translation') as $languageCode => $input) {
            $translation = static::getByLanguageCode($translations, $languageCode);

            if (TranslationValidator::filled($input, $isRoutine)) {
                if (is_null($translation)) {
                    static::createSingle($class, $parent, $input, $languageCode);
                } else {
                    $translation->update($input);
                }
            } elseif (!is_null($translation)) {
                $translation->delete();
            }
        }
    }

    /**
     * Returns the translation for the given language code or {@code null}.
     *
     * @param $translations
     * @param $languageCode
     *
     * @return Translation
     */
    public static function getByLanguageCode($translations, $languageCode)
    {
        foreach ($translations as $translation) {
            if ($translation->language_code == $languageCode) {
                return $translation;
            }
        }

        return null;
    }

    /**
     * Merges the given flash array with flash input for translations.
     *
     * @param Collection $translations
     * @param array $flash
     * @param bool $isRoutine
     */
    public static function mergeFlash(Collection $translations, array &$flash, $isRoutine = false)
    {
        foreach (LaravelLocalization::getSupportedLanguagesKeys() as $languageCode) {
            $t = self::getByLanguageCode($translations, $languageCode);
            $p = 'translation.' . $languageCode . '.';

            if (!$isRoutine) {

                //used to create translations for workouts
                $flash['translation'][$languageCode] = [
                    'title' => SessionUtil::old($t, $p, 'title'),
                    'title_in_app' => SessionUtil::old($t, $p, 'title_in_app'),
                    'starting_position' => SessionUtil::old($t, $p, 'starting_position'),
                    'execution' => SessionUtil::old($t, $p, 'execution'),
                    'hints' => SessionUtil::old($t, $p, 'hints'),
                    'difficulty' => SessionUtil::old($t, $p, 'difficulty')
                ];
            } else {
                $flash['translation'][$languageCode] = [
                    'title' => SessionUtil::old($t, $p, 'title'),
                    'description' => SessionUtil::old($t, $p, 'description'),
                    'injuries' => SessionUtil::old($t, $p, 'injuries'),
                ];
            }
        }
    }
}
