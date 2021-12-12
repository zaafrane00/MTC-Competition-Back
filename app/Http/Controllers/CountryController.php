<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Exception;
use Illuminate\Http\Request;
use App\Models\Country;
use Illuminate\Http\Exceptions\HttpResponseException;


class CountryController extends Controller
{
    public function index()
    {
        $data = [];
        $messages = "Unauthorized to access to data";
        $errors = "Unauthorized";
        $status = HttpResponse::HTTP_UNAUTHORIZED;
        try {
            $countries = Country::where('status', 1)
                ->orderBy('nom')
                ->take(10)
                ->get();

            $status = HttpResponse::HTTP_OK;
            $data = ['countries' => $countries];
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
        $country = Country::create(array_merge(
            $validator->validated()

        ));
        $status = HttpResponse::HTTP_OK;
        $data = [
            'country' => $country
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
            $country = Country::findOrFail($id);
            $res = $country->update(array_merge(
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
