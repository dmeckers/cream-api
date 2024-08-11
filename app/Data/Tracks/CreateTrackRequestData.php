<?php

declare(strict_types=1);

namespace App\Data\Tracks;

use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Data;

class CreateTrackRequestData extends Data
{
    public function __construct(
        public UploadedFile $file,
        public ?string $name = 'Unknown Track',
        public ?string $artist = 'Unknown Artist',
        public ?string $album = 'Unknown Album',
        public ?string $genre = 'Unknown Genre',
        public ?int $year,
        public ?int $length,
        public ?int $plays,
        public ?int $rating,
    ) {
    }
}