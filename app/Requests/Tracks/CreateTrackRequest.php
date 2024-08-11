<?php

declare(strict_types=1);

namespace App\Requests\Tracks;

use App\Data\Tracks\CreateTrackRequestData;
use App\Http\Resources\TrackResource;
use App\Models\Track;
use Illuminate\Foundation\Http\FormRequest;

class CreateTrackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function data(): CreateTrackRequestData
    {
        return resolve(CreateTrackRequestData::class);
    }

    public function resourceResponse(Track $track): TrackResource
    {
        return TrackResource::make($track);
    }
}