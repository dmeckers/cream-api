<?php

declare(strict_types=1);

namespace App\Repositories\Stations;

class StationLogicRepository
{

    public function __construct(private readonly StationDbRepository $stationDbRepository)
    {
    }

}