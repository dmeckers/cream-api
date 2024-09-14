<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Stations\DeleteStationRequest;
use App\Http\Requests\Stations\GetStationRequest;
use App\Http\Requests\Stations\ListPlaylistsRequest;
use App\Http\Requests\Stations\StoreStationRequest;
use App\Http\Requests\Stations\UpdateStationRequest;
use App\Repositories\Stations\StationLogicRepository;
use Illuminate\Routing\Controller;

class StationsController extends Controller
{
    public function __construct(StationLogicRepository $stationLogicRepository)
    {
    }

    public function list(ListPlaylistsRequest $requests)
    {

    }

    public function storeStation(StoreStationRequest $requests)
    {

    }

    public function deleteStation(DeleteStationRequest $requests)
    {

    }

    public function getStation(GetStationRequest $requests)
    {

    }

    public function updateStation(UpdateStationRequest $requests)
    {

    }
}