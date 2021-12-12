<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Exception;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;


class UserController extends Controller
{
    public function index()
    {
        $data = [];
        $messages = "Unauthorized to access to data";
        $errors = "Unauthorized";
        $status = HttpResponse::HTTP_UNAUTHORIZED;
        try {
            $users = User::where('status', 1)
                ->orderBy('name', 'asc')
                ->take(10)
                ->get();

            $status = HttpResponse::HTTP_OK;
            $data = ['users' => $users];
            $errors = "";
            $messages = "";
        } catch (ModelNotFoundException $e) {
            $data = [];
            $errors = $e->getMessage();
            $messages = "Files not Found";
            $status = HttpResponse::HTTP_UNAUTHORIZED;
        } catch (Exception $e) {
            $data = [];
            $errors = $e->getMessage();
            $messages = "Internal Server Error";
            $status = HttpResponse::HTTP_INTERNAL_SERVER_ERROR;
        }
        return $this->apiResponse($data, $messages, $errors, $status);
    }


    public function store(Request $request)
    {
        $data = [];
        $messages = "Unauthorized to access to data";
        $errors = "Unauthorized";
        $status = HttpResponse::HTTP_UNAUTHORIZED;

        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::create(array_merge(
            $validator->validated()

        ));
        $status = HttpResponse::HTTP_OK;
        $data = [
            'user' => $user
        ];
        $country->save();
        $errors = "";
        $messages = "Pack created successfully";
        return $this->apiResponse($data, $messages, $errors, $status);
    }

    public function update($id, Request $request)
    {
        $data = [];
        $messages = "Unauthorized to access to data";
        $errors = "Unauthorized";
        $status = HttpResponse::HTTP_UNAUTHORIZED;
        try {
            $validator = Validator::make($request->all(), [
                'nom' => 'required|string|max:255',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson(), 400);
            }
            $user = User::findOrFail($id);
            $res = $user->update(array_merge(
                $validator->validated()
            ));

            $status = HttpResponse::HTTP_OK;
            $data = [
                'country' => $country
            ];

            $errors = "";
            $messages = "Pack created successfully";
        } catch (ModelNotFoundException $e) {
            $data = [];
            $errors = $e->getMessage();
            $messages = "Country Not Found";
            $status = HttpResponse::HTTP_UNAUTHORIZED;
        }
        return $this->apiResponse($data, $messages, $errors, $status);
    }
}
