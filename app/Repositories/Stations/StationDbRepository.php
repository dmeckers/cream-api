<?php

declare(strict_types=1);

namespace App\Repositories\Stations;
use App\Models\RadioStation;

class StationDbRepository
{
    public function __construct(private readonly RadioStation $radioStation)
    {
    }
}