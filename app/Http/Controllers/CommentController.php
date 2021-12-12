<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index()
    {
        $data = [];
        $messages = "Unauthorized to access to data";
        $errors = "Unauthorized";
        $status = HttpResponse::HTTP_UNAUTHORIZED;
        try {
            $comments = Comment::all();

            $status = HttpResponse::HTTP_OK;
            $data = ['comments' => $comments];
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
            'post_id' => 'required|integer',
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
                'body' => 'required|string|max:255',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson(), 400);
            }
            $comment = Comment::findOrFail($id);
            $res = $comment->update(array_merge(
                $validator->validated()
            ));

            $status = HttpResponse::HTTP_OK;
            $data = [
                'comment' => $comment
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
