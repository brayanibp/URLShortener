<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenerateShortUrlRequest;
use App\Models\ShortenedUrl;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class URLShortenerController extends Controller
{
    /**
     * Summary of Home
     * @return \Inertia\Response
     * @OA\Get(
     *     path="/",
     *     operationId="index",
     *     tags={"Home"},
     *     summary="Prints a URLs Dashboard",
     *     description="Prints a URLs Dashboard",
     *     @OA\Response(
     *       response="200",
     *       description="Successful dashboard print",
     *       content={
     *          @OA\MediaType(
     *              mediaType="text/html",
     *              @OA\Schema(
     *                  type="string",
     *                  example="<h1>URL Shortener</h1>"
     *              ),
     *          ),
     *       },
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Bad Request",
     *         content={
     *          @OA\MediaType(
     *              mediaType="text/html",
     *              @OA\Schema(
     *                  type="string",
     *                  example="<h1>Bad Request</h1>"
     *              ),
     *          ),
     *       },
     *     ),
     *      @OA\Response(
     *         response="500",
     *         description="Server Internal Error",
     *         content={
     *          @OA\MediaType(
     *              mediaType="text/html",
     *              @OA\Schema(
     *                  type="string",
     *                  example="<h1>Server Internal Error</h1>"
     *              ),
     *          ),
     *       },
     *     ),
     * )
     */
    public function index()
    {

        return Inertia::render("Dashboard/Index", [
            // "urls" => ShortenedUrl::all(),
            "urls" => [
                [
                    'original_url' => 'https://brayanibp.dev',
                    'short_url' => 'http://localhost:8000/bibp',
                ]
            ],
        ]);
    }


    /**
     * Summary of generateShortUrl
     * @param \App\Http\Requests\GenerateShortUrlRequest $request
     * @return Response
     *
     */
    public function generateShortUrl(GenerateShortUrlRequest $request)
    {
        return response()->json([
            'short_url' => 'XXXXXXXXXXXXXXXXXXXXXX' . $request->original_url
        ], Response::HTTP_OK);
    }

    /**
     * Summary of showRedirect
     * @param mixed $shortenedUrl
     * @return \Inertia\Response
     */
    public function showRedirect($shortenedUrl) {
        return Inertia::render('Redirect/Index', [
            'url' => $shortenedUrl
        ]);
    }

    /**
     * Summary of redirectToOriginalUrl
     * @param mixed $shortUrl
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function redirectToOriginalUrl($shortUrl)
    {
        $originalUrl = ShortenedUrl::where('short_url', $shortUrl)->firstOrFail()->original_url;
        return redirect('https://brayanibp.dev', Response::HTTP_PERMANENTLY_REDIRECT);
    }
}
