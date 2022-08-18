<?php

namespace Api\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function okResponse(array|Arrayable|JsonResource|NULL $data)
    {
        if ($data instanceof Arrayable) {
            $data = $data->toArray();
        }

        if (isset($data['data'])) {
            return response()->json(array_merge([
                'status' => true,
            ], $data));
        }

        return response()->json([
            'status' => true,
            'data' => $data,
        ]);
    }

    protected function errorResponse(string|\Exception $error, int $status = 500)
    {
        $message = $error instanceof \Exception ? $error->getMessage() : $error;

        return response()->json([
            'status' => false,
            'message' => $status === 500 ? 'An internal error has occurred: ' . $message : $message,
        ], $status);
    }
}
