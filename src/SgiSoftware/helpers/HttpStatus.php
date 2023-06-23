<?php

/**
 * User: alaspina
 * Date: 12-Feb-2023
 * Time: 16:49
 */

namespace SgiSoftware\Helpers;

class StatusHelper
{
    static function getStatusCodeText($status)
    {
        switch ($status) {
            case Response::STATUS_LOGIN_TIMEOUT;
                $statusText = 'LOGIN TIME-OUT';
                break;
            case Response::STATUS_UNAUTHORIZE;
                $statusText = 'UNAUTHORIZE';
                break;
            case Response::STATUS_BAD_REQUEST;
                $statusText = 'BAD REQUEST';
                break;
            case Response::STATUS_NOT_FOUND;
                $statusText = 'NOT FOUND';
                break;
            case Response::STATUS_OK;
                $statusText = 'OK';
                break;
            case Response::STATUS_FORBIDDEN;
                $statusText = 'FORBIDDEN';
                break;
        }

        return $statusText;
    }
}
