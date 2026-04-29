<?php
namespace App\Helpers;
trait ApiResponse
{
    function success(mixed $data, string $message)
    {
        $response = [];
        $response['status'] = 'success';
        $response['message'] = $message;
        if (is_null($data)) {
            $response['data'] = $data;
        }
        return response()->json($response, 200);
    }

    public function created(mixed $data, string $message)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], 201);
    }

    function notFound(string $message)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], 404);
    }

    public function resPaginate(string $message, $data)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
            'paginate' => [
                'total' => $data->total(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'has_more_pages' => $data->hasMorePages(),
                'has_pages' => $data->hasPages()
            ],
            'links' => [
                'prev' => $data->previousPageUrl(),
                'next' => $data->nextPageUrl(),
            ],
        ]);
    }

    public function unauthorized(string $message = 'Unauthorized')
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], 401);
    }

    public function forbidden(string $message = 'Forbidden')
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], 403);
    }

    public function badRequest(string $message = 'Bad Request')
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], 400);
    }

    public function error(string $message = 'Internal Server Error', mixed $exception = null)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], 500);
    }

}