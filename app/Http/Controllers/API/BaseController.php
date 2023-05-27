<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @param  array|string|\stdClass  $result
     * @param  string  $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @param  string  $error
     * @param  string|array|object|null  $errorMessages
     * @param  int  $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];
        if (! empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }


    /**
     * JSON object for Weather data
     * @return Array 
     */
    public function getWeatherDataObject($weather)
    {
        if ($card != '') {
            $send = [];
            $send['card_id'] = $card['id'];
            $send['brand'] = $card['brand'];
            $send['country'] = $card['country'];
            $send['fingerprint'] = $card['fingerprint'];
            $send['exp_month'] = $card['exp_month'];
            $send['exp_year'] = $card['exp_year'];
            $send['fingerprint'] = $card['fingerprint'];
            $send['card_type'] = $card['funding'];
            $send['last4'] = $card['last4'];
            $send['cvc_check'] = $card['cvc_check'];
            $send['card_name'] = $card['metadata']['name'] ?? '';
            $send['is_primary'] = ($card['id'] == $default) ?? false;

            return $send;
        }
    }

}
