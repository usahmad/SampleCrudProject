<?php

use App\Functionality\Constants;

if (!function_exists('priorities')){
    function priorities(): array
    {
        return Constants::priorities;
    }
}
