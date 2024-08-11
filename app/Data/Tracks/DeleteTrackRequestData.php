<?php

declare(strict_types=1);

namespace App\Data\Tracks;

use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Data;

class DeleteTrackRequestData extends Data
{
    public function __construct(
        #[Exists(Track::TABLE, Track::ID)]
        public int $id,
    ) {
    }
}