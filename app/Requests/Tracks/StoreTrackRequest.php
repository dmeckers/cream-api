<?php

declare(strict_types=1);

namespace App\Requests\Tracks;

use App\Data\Tracks\StoreTrackRequestData;
use App\Http\Resources\TrackResource;
use App\Models\Track;
use Illuminate\Foundation\Http\FormRequest;

class StoreTrackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function data(): StoreTrackRequestData
    {
        return resolve(StoreTrackRequestData::class);
    }

    public function resourceResponse(Track $track): TrackResource
    {
        return TrackResource::make($track);
    }
}