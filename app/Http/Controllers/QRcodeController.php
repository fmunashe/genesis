<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQRcodeRequest;
use App\Models\QRcode;
use Illuminate\Http\JsonResponse;
use Random\RandomException;

class QRcodeController extends BaseController
{

    public function index(): JsonResponse
    {
        $codes = QRcode::query()->latest()->paginate(10);
        return $this->buildSuccessResponse($codes, 'Codes retrieved successfully');
    }


    /**
     * @throws RandomException
     */
    public function store(StoreQRcodeRequest $request): JsonResponse
    {
        $code = QRcode::query()->firstOrCreate([
            'code' => random_int(10000000, 99999999),
            'used' => false
        ]);
        return $this->buildSuccessResponse($code, 'Code generated successfully');
    }


    public function show(QRcode $qRcode): JsonResponse
    {
        return $this->buildSuccessResponse($qRcode, "Code retrieved successfully");
    }

    public function verify($qRcode): JsonResponse
    {
        $code = QRcode::query()->firstWhere('code', $qRcode);
        if ($code == null) {
            return $this->buildErrorResponse('Provided code ' . $qRcode . " is invalid");
        }
        if ($code->used) {
            return $this->buildErrorResponse('Provided code ' . $qRcode . " has already been used");
        }

        $code->update([
            'used' => true
        ]);
        return $this->buildSuccessResponse($qRcode, "Code verified successfully");
    }

}
