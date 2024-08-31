<?php

declare(strict_types=1);

namespace App\Http\Requests\Tracks;

use App\Http\Data\Tracks\StoreTrackRequestData;
use App\Http\Resources\TrackResource;
use App\Models\Track;
use App\Utils\ValidationRuleHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class StoreTrackRequest extends FormRequest
{
    private const FILE   = 'file';
    private const NAME   = 'name';
    private const ARTIST = 'artist';
    private const ALBUM  = 'album';
    private const GENRE  = 'genre';
    private const YEAR   = 'year';
    private const LENGTH = 'length';
    private const PLAYS  = 'plays';
    private const RATING = 'rating';

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
        return new TrackResource($track);
    }
}