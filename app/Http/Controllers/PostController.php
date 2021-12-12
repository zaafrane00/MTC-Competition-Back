<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Exception;
use App\Models\Country;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Controllers\Api\Controller;

class PostController extends Controller
{
    public function index()
    {

        $data = [];
        $messages = "Unauthorized to access to data";
        $errors = "Unauthorized";
        $status = HttpResponse::HTTP_UNAUTHORIZED;
        try {
            $posts = Post::where('status', '0')
                ->withCount('comments')
                ->with('comments')
                ->get();
            $data = [
                'posts' => $posts
            ];
            $status = HttpResponse::HTTP_OK;
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
            'body' => 'required|string|max:255',
            'user_id' => 'required|integer',
            'type' => 'required',
            'address' => 'required|string|max:255',
            'country_id' => 'required|integer',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $post = Post::create(array_merge(
            $validator->validated()

        ));
        $status = HttpResponse::HTTP_OK;
        $data = [
            'post' => $post
        ];
        $post->save();
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
                'body' => 'required|string|max:255',
                'user_id' => 'required|integer',
                'type' => 'required',
                'address' => 'required|string|max:255',
                'country_id' => 'required|integer',

            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson(), 400);
            }
            $post = Post::findOrFail($id);
            $res = $post->update(array_merge(
                $validator->validated()
            ));

            $status = HttpResponse::HTTP_OK;
            $data = [
                'comment' => $post
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
