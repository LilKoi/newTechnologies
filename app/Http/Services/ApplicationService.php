<?php

namespace App\Http\Services;

use App\Models\Application;
use App\Models\Position;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ApplicationService
{

    public function __construct(private CategoryService $categoryService)
    {
    }


    public function updatePositionsinCategory(array $data)
    {
        $newPositions = $this->getPositionsInApi($data["applicationId"], $data["countryId"], $data["dateFrom"], $data["dateTo"]);
        $applicationId = $data["applicationId"];
        DB::transaction(function () use ($newPositions, $applicationId) {
            $this->getOrCreateApplication($applicationId);
            foreach ($newPositions["data"] as $category => $subCategoryArray) {
                $modelCategory = $this->categoryService->getOrCreateCategory($applicationId, $category);
                foreach ($subCategoryArray as  $subCategory => $positions) {
                    $subModelCategory =  $this->categoryService->getOrCreateCategory($applicationId, $subCategory, $modelCategory->id);
                    foreach ($positions as $date => $position) {
                        Position::create([
                            "category_id" => $subModelCategory->id,
                            "date" => $date,
                            'value' => $position
                        ]);
                    }
                }
            }
        });
    }

    public function getOrCreateApplication(int $name): Application
    {
        return Application::firstOrCreate(["name" => $name]);
    }

    private function getPositionsInApi(int $applicationId, int $countryId, string $dateFrom, string $dateTo)
    {
        $url = "https://api.apptica.com/package/top_history/$applicationId/$countryId?date_from=$dateFrom&date_to=$dateTo";
        try {
            $request = Http::get($url);
            $response = $request->json();
            if ($request->getStatusCode() == 200) {
                return $response;
            } else {
                throw new Exception("что-то пошло не так, статус не 200");
            }
        } catch (\Exception $e) {
            new Exception($e->getMessage());
        }
    }
}
