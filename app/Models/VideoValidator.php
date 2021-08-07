<?php

namespace App\Models;


use Illuminate\Validation\Validator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class VideoValidator extends Validator
{
    protected function validateVideo($attribute, $value, $parameters, $validator) {
        if (!$value instanceof UploadedFile) {
            return false;
        }

        if ($value->getClientOriginalExtension() != 'mp4') {
            return false;
        }

        $videoInfo = VideoInfo::toVideoInfo($value);
        $parsedParameters = $this->parseNamedParameters($parameters);

        if (
            isset($parsedParameters['codec']) && $parsedParameters['codec'] != $videoInfo->codec() ||
            isset($parsedParameters['max_width']) && $parsedParameters['max_width'] < $videoInfo->width() ||
            isset($parsedParameters['max_height']) && $parsedParameters['max_height'] < $videoInfo->height() ||
            isset($parsedParameters['max_length']) && $parsedParameters['max_length'] < $videoInfo->length()
        ) {
            return false;
        }

        return true;
    }

    protected function replaceVideo($message, $attribute, $rule, $parameters) {
        if (!empty($parameters)) {
            $parsedParameters = $this->parseNamedParameters($parameters);

            $message .= '<br><ul>';

            $message .= '<li>'. trans('messages.validation.video.format', $parsedParameters) .'</li>';

            if (isset($parsedParameters['codec'])) {
                $message .= '<li>'. trans('messages.validation.video.codec', $parsedParameters) .'</li>';
            }

            if (isset($parsedParameters['max_width']) && isset($parsedParameters['max_height'])) {
                $message .= '<li>'. trans('messages.validation.video.max.resolution', $parsedParameters) .'</li>';
            }

            if (isset($parsedParameters['max_length'])) {
                $message .= '<li>'. trans('messages.validation.video.max.length', $parsedParameters) .'</li>';
            }

            $message .= '</ul>';
        }

        return $message;
    }
}