<?php

declare(strict_types=1);

namespace App\Requests\Tracks;

use App\Http\Resources\TrackResource;
use App\Models\Track;
use Illuminate\Foundation\Http\FormRequest;

class GetTrackRequest extends FormRequest
{
    private const TRACK_ID_ROUTE_KEY = 'track';

    public function authorize(): bool
    {
        return true;
    }

    public function getTrackId(): int
    {
        return (int) $this->route(self::TRACK_ID_ROUTE_KEY);
    }

    public function resourceResponse(Track $track): TrackResource
    {
        return TrackResource::make($track);
    }
}