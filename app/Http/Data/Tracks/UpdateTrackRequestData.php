<?php

declare(strict_types=1);

namespace App\Http\Data\Tracks;

use App\Models\Track;
use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Data;

class UpdateTrackRequestData extends Data
{
    public function __construct(
        #[Exists(Track::TABLE, Track::ID)]
        public int $id,
        public ?string $name,
        public ?string $artist,
        public ?string $album,
        public ?string $genre,
        public ?int $year,
        public ?int $length,
        public ?int $plays,
        public ?int $rating,
        public ?UploadedFile $file
    ) {
    }
}