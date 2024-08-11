<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TrackResourceCollection extends ResourceCollection
{
    public $collects = TrackResource::class;
}