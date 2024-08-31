<?php

declare(strict_types=1);

namespace App\Http\Data\Tracks;

use Illuminate\Http\UploadedFile;

class PlainStoreTrackRequestData
{
    public const FILE = 'file';

    public function __construct(
        public UploadedFile $file,
    ) {
    }
}