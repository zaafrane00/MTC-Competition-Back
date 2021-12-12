<?php

namespace App\Http\Controllers\Api;

class Controller
{

    public static function apiResponse($data, $messages, $errors, $status)
    {

        if ($errors == null || $messages == null) {
            $success = TRUE;

            $response = [
                'status' => $status, 'success' => $success, "data" => $data, "messages" => $messages
            ];
            return response()->json($response, $status);
        } else {
            $success = FALSE;
            $response = ['meta' => [
                'errors' => [
                    'fields' => $errors,
                    'message' => $messages
                ],
                'success' => $success, 'status' =>
                $status, "messages" => $messages
            ]];
            return response()->json($response, $status);
        }
    }
}
