<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenerateShortUrlRequest;
use App\Models\ShortenedUrl;
use Illuminate\Support\Str;
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
            "urls" => ShortenedUrl::all(['original_url', 'short_url']),
        ]);
    }

    /**
     * Summary of showAddForm
     * @return \Inertia\Response
     */
    public function showAddForm() {
        return Inertia::render('Add/Index');
    }


    /**
     * Summary of generateShortUrl
     * @param \App\Http\Requests\GenerateShortUrlRequest $request
     * @return Response
     * @OA\Post(
     *     path="/generate-short-url",
     *     operationId="generateShortUrl",
     *     tags={"URL Shortener"},
     *     summary="Generate a short URL",
     *     description="Generate a short URL",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="url", type="string", example="https://brayanibp.dev"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation",
     *         content={
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  @OA\Property(property="short_url", type="string", example="http://localhost:8000/emPjo"),
     *              ),
     *          ),
     *       },
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Bad Request",
     *         content={
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  @OA\Property(property="message", type="string", example="Bad Request"),
     *              ),
     *          ),
     *       },
     *     ),
     *      @OA\Response(
     *         response="500",
     *         description="Server Internal Error",
     *         content={
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  @OA\Property(property="message", type="string", example="Server Internal Error"),
     *              ),
     *          ),
     *       },
     *     ),
     * )
     *
     * @param \App\Http\Requests\GenerateShortUrlRequest $request
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function generateShortUrl(GenerateShortUrlRequest $request)
    {
        // getting the shard id from config
        $db_shard = config('app.db_shard');

        // getting the url from request
        $original_url = $request->url;

        // creating the url record and obtaining url ID
        $url_instance = ShortenedUrl::create([
            'original_url' => $original_url,
            'short_url' => $original_url,
        ]);

        // saving the url record
        $url_instance->save();

        // getting the url ID
        $url_id = str_replace("-", "", $url_instance->id);

        // filling the url ID with zeros
        $number_secuence = hexdec($url_id);

        // base 62 encoding the url ID
        $base62 = base62_encode((float) "$db_shard$number_secuence");

        // updating the url with the short url
        $url_instance->update([
            'short_url' => $base62,
        ]);

        // returns short URL
        return response()->json([
            'id' => $url_instance->id,
            'number' => $number_secuence,
            // returns the short URL
            'short_url' => $base62,
            'original_url' => $original_url,
        ], Response::HTTP_CREATED);
    }

    /**
     * Summary of showRedirect
     * @OA\Get(
     *     path="/redirect/{shortenedUrl}",
     *     operationId="showRedirect",
     *     tags={"URL Shortener"},
     *     summary="Show redirect page",
     *     description="Show redirect page",
     *     @OA\Parameter(
     *         name="shortenedUrl",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="emPjo"
     *         ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation",
     *         content={
     *          @OA\MediaType(
     *              mediaType="text/html",
     *              @OA\Schema(
     *                  type="string",
     *                  example="<h1>Redirect</h1>"
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
     *
     * @param mixed $shortenedUrl
     * @return \Inertia\Response
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function showRedirect($shortenedUrl) {
        return Inertia::render('Redirect/Index', [
            'url' => $shortenedUrl
        ]);
    }

    /**
     * Summary of redirectToOriginalUrl
     * @param string $short_url
     * @return mixed|\Illuminate\Http\JsonResponse
     * @OA\Get(
     *     path="/{short_url}",
     *     operationId="redirectToOriginalUrl",
     *     tags={"URL Shortener"},
     *     summary="Redirect to original URL",
     *     description="Redirect to original URL",
     *     @OA\Parameter(
     *         name="short_url",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="emPjo"
     *         ),
     *     ),
     *     @OA\Response(
     *         response="202",
     *         description="Accepted",
     *         content={
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  @OA\Property(property="url", type="string", example="https://brayanibp.dev"),
     *              ),
     *          ),
     *       },
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="URL not found",
     *         content={
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  @OA\Property(property="error", type="string", example="URL not found"),
     *              ),
     *          ),
     *       },
     *     ),
     * )
     *
     * @param string $short_url
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function redirectToOriginalUrl(string $short_url)
    {
        $redirection_url = request()->getHttpHost();

        try {
            $redirection_url = ShortenedUrl::where('short_url', $short_url)->firstOrFail()->original_url;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'URL not found', 'redirect' => $redirection_url], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['url' => $redirection_url], Response::HTTP_ACCEPTED);
    }

    /**
     * Summary of removeShortenedUrl
     * @OA\Delete(
     *     path="/{shortened_url}",
     *     operationId="removeShortenedUrl",
     *     tags={"URL Shortener"},
     *     summary="Remove shortened URL",
     *     description="Remove shortened URL",
     *     @OA\Parameter(
     *         name="shortened_url",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="emPjo"
     *         ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation",
     *         content={
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  @OA\Property(property="message", type="string", example="URL removed successfully"),
     *                  @OA\Property(
     *                      property="urls",
     *                      type="array",
     *                      @OA\Items(
     *                          type="object",
     *                          @OA\Property(property="original_url", type="string", example="https://brayanibp.dev"),
     *                          @OA\Property(property="short_url", type="string", example="http://localhost:8000/emPjo"),
     *                      ),
     *                  ),
     *              ),
     *          ),
     *       },
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Bad Request",
     *         content={
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  @OA\Property(property="message", type="string", example="Bad Request"),
     *              ),
     *          ),
     *       },
     *     ),
     *      @OA\Response(
     *         response="500",
     *         description="Server Internal Error",
     *         content={
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  @OA\Property(property="message", type="string", example="Server Internal Error"),
     *              ),
     *          ),
     *       },
     *     ),
     * )
     *
     * @param string $shortened_url
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function removeShortenedUrl(string $shortened_url) {
        // Find the shortened URL record by its short URL
        ShortenedUrl::where('short_url', $shortened_url)->delete();

        // retreaving left shorten URLs
        $shortened_urls = ShortenedUrl::all(['original_url', 'short_url']);

        return response()->json([
            'message' => 'URL removed successfully',
            'urls' => $shortened_urls,
        ], Response::HTTP_OK);
    }
}
