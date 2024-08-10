<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class URLShortenerController extends Controller
{
    /**
        * @OA\Post(
        *     path="/api/register",
        *     operationId="registerUser",
        *     tags={"Register"},
        *     summary="Register a new user",
        *     description="User Registration Endpoint",
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *             mediaType="multipart/form-data",
        *             @OA\Schema(
        *                 type="object",
        *                 required={"name","email","password","password_confirmation"},
        *                 @OA\Property(property="name",type="text"),
        *                 @OA\Property(property="email",type="text"),
        *                 @OA\Property(property="password",type="password"),
        *                 @OA\Property(property="password_confirmation",type="password"),
        *             ),
        *         ),
        *     ),
        *     @OA\Response(
        *         response="201",
        *         description="User Registered Successfully",
        *         @OA\JsonContent()
        *     ),
        *     @OA\Response(
        *       response="200",
        *       description="Registered Successfull",
        *       @OA\JsonContent()
        *     ),
        *     @OA\Response(
        *         response="422",
        *         description="Unprocessable Entity",
        *         @OA\JsonContent()
        *     ),
        *     @OA\Response(
        *         response="400",
        *         description="Bad Request",
        *         @OA\JsonContent()
        *     ),
        * )
        */
    public function index()
    {
        return response()->json([
            'message' => 'URL Shortener API'
        ]);
    }
}
