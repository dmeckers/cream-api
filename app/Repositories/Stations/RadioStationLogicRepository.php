<?php

declare(strict_types=1);

namespace App\Repositories\Stations;
use App\Http\Data\RadioStations\UpdateStationData;
use App\Http\Requests\Stations\StartStationRequest;
use App\Http\Requests\Stations\StopStationRequest;
use App\Jobs\StartStationJob;
use App\Jobs\StopStationJob;
use App\Models\RadioStation;

class RadioStationLogicRepository
{

    public function __construct(private readonly RadioStationDbRepository $radioStationDbRepository)
    {
    }

    public function findOrFail(int $stationId): RadioStation
    {
        return $this->radioStationDbRepository->findOrFail($stationId);
    }

    public function startStation(array $data): void
    {
        $station = $this->findOrFail($data[StartStationRequest::STATION_ID_ROUTE_KEY]);

        dispatch(new StartStationJob($station));

        $station->updateOrFail([RadioStation::IS_LIVE => true]);
    }

    public function stopStation(array $data): void
    {
        $station = $this->findOrFail($data[StopStationRequest::STATION_ID_ROUTE_KEY]);

        dispatch(new StopStationJob($station));

        $station->updateOrFail([RadioStation::IS_LIVE => false]);
    }

    // public function updateStation(UpdateStationData $data): void
    // {
    //     $this->RadioStationDbRepository->updateStation(
    //         $data->stationId,
    //         [
    //             RadioStation::MOUNT_POINT => $data->mountPoint,
    //             RadioStation::DESCRIPTION => $data->description,
    //             RadioStation::GENRE => $data->genre,
    //         ]
    //     );
    // }
}