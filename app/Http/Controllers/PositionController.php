<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetPositionsInApplicationRequest;
use App\Http\Services\PositionService;

class PositionController extends Controller
{
    public function __construct(public PositionService $service)
    {
    }

    public function index(GetPositionsInApplicationRequest $validate)
    {
        $data = $validate->validated();
        return response()->json([
            "status_code" => 200,
            "message" => "ok",
            'data' => $this->service->getPositions($data["date"])
        ]);
    }
}
