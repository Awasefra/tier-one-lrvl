<?php

namespace App\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

trait ApiResponse
{
    /**
     * Response sukses (single resource / action)
     */
    protected function success($data = null, string $message = 'OK', int $httpCode = 200)
    {
        return response()->json([
            'meta' => [
                'success' => true,
                'message' => $message,
            ],
            'data' => $data,
        ], $httpCode);
    }

    /**
     * Response gagal (manual / business error)
     */
    protected function fail(string $message = 'Bad Request', int $httpCode = 400, $errors = null)
    {
        return response()->json([
            'meta' => [
                'success' => false,
                'message' => $message,
            ],
            'errors' => $errors,
            'data' => null,
        ], $httpCode);
    }

    /**
     * Response pagination (collection)
     */
    protected function paginate(
        LengthAwarePaginator $paginator,
        $items,
        string $message = 'OK',
        int $httpCode = 200
    ) {
        return response()->json([
            'meta' => [
                'success' => true,
                'message' => $message,
                'pagination' => [
                    'total'        => $paginator->total(),
                    'count'        => $paginator->count(),
                    'per_page'     => $paginator->perPage(),
                    'current_page' => $paginator->currentPage(),
                    'last_page'    => $paginator->lastPage(),
                ],
            ],
            'data' => $items,
        ], $httpCode);
    }
}
