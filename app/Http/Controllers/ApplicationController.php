<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAppCategoryPositionsRequest;
use App\Http\Services\ApplicationService;
use App\Http\Requests\GetPositionsInApplicationRequest;

class ApplicationController extends Controller
{
    public function __construct(public ApplicationService $applicationService)
    {
    }


    public function store(UpdateAppCategoryPositionsRequest $validate)
    {
        $data = $validate->validated();
        $this->applicationService->updatePositionsinCategory($data);
        
        return response()->noContent();
    }
}
