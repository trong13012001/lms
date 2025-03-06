<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class LogHelper
{
    public static function info($content) {
        Log::info($content);
    }

    public static function error($content = '', $exception = null) {
        if (!is_null($exception)) {
            $content .= '. Msg: '.$exception->getMessage().'. File:'.$exception->getFile().'. Line:'.$exception->getLine();
        }
        Log::error($content);
    }
}
