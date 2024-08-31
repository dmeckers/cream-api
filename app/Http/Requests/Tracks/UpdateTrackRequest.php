<?php

declare(strict_types=1);

namespace App\Http\Requests\Tracks;

use App\Http\Data\Tracks\UpdateTrackRequestData;
use App\Http\Resources\TrackResource;
use App\Models\Track;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTrackRequest extends FormRequest
{
    private const TRACK_ID_ROUTE_KEY = 'track';

    public function authorize(): bool
    {
        return true;
    }

    public function resourceResponse(Track $track): TrackResource
    {
        return TrackResource::make($track);
    }

    protected function prepareForValidation(): void
    {
        $this->merge([Track::ID => $this->getTrackId()]);
    }

    private function getTrackId(): int
    {
        return (int) $this->route(self::TRACK_ID_ROUTE_KEY);
    }

    public function data(): UpdateTrackRequestData
    {
        return resolve(UpdateTrackRequestData::class);
    }
}