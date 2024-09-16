<?php

declare(strict_types=1);

namespace App\Repositories\Stations;
use App\Models\RadioStation;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RadioStationDbRepository
{
    public function __construct(private readonly RadioStation $radioStation)
    {
    }

    /**
     * @throws ModelNotFoundException
     */
    public function findOrFail(int $stationId): RadioStation
    {
        return $this->radioStation->findOrFail($stationId);
    }

    // /**
    //  * @throws ModelNotFoundException
    //  */
    // public function updateStation(int $stationId, array $data): void
    // {
    //     $this->radioStation->find($stationId)->updateOrFail($data);
    // }
}