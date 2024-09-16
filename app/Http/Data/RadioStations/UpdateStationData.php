<?php

declare(strict_types=1);

namespace App\Http\Data\RadioStations;

use Spatie\LaravelData\Data;

class UpdateStationData extends Data
{
    public function __construct(
        public int $stationId,
        public string $stationName,
        public string $playlistName,
        public string $mountPoint,
        public ?string $description = "No description provided",
        public ?string $genre = "No genre provided",
    ) {
    }
}