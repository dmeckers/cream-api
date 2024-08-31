<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrackResource extends JsonResource
{
    /**
     * @var Track
     */
    public $resource;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->getId(),
            'name' => $this->resource->getName(),
            'artist' => $this->resource->getArtist(),
            'album' => $this->resource->getAlbum(),
            'genre' => $this->resource->getGenre(),
            'year' => $this->resource->getYear(),
            'length' => $this->resource->getLength(),
            'plays' => $this->resource->getPlays(),
            'rating' => $this->resource->getRating(),
            'file_url' => $this->resource->getFileUrl(),
        ];
    }
}