<?php

namespace App\Services;


use LaravelLocalization;
use Mail;

class Mailer
{
    /**
     * @param string $view
     * @param array $data
     * @param callable $callback
     */
    public function send($view, $data, $callback) {
        $locale = LaravelLocalization::getCurrentLocale();
        $fullViewName = "emails.$locale.$view";

        Mail::send($fullViewName, $data, $callback);
    }
}