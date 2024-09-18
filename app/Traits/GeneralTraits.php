<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait GeneralTraits
{
    public function getCurrentLang(): string
    {
        return app()->getLocale();
    }

    public function returnData($key, $value, $message = null): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            $key => $value,
        ], 200);
    }

    public function returnError($errorCode, $errorMessage): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $errorMessage,
            'errorCode' => $errorCode,
        ], 200);
    }

    public function returnSuccessMessage($statusCode = 200, $message = null): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message,
        ], $statusCode);
    }

    public function returnValidationError($errorCode = "E001", $validator): JsonResponse
    {
        return $this->returnError($errorCode, $validator->errors()->first());
    }

    public function returnCodeAccordingToInput($validator)
    {
        $input = array_keys($validator->errors()->toArray());
        return $this->getErrorCode($input[0]);
    }

    public function getErrorCode($input)
    {
        // Implement your logic to retrieve the error code based on the input
        // Example: Map the input to specific error codes

        return $errorCode;
    }
}
