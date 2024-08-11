<?php

declare(strict_types=1);

namespace App\Requests\Tracks;

use App\Http\Resources\TrackResourceCollection;
use App\Utils\PermissionBook;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;

class ListTrackRequest extends FormRequest
{
    public function authorize(Gate $gate): bool
    {
        return $gate->allows(PermissionBook::VIEW_ALL_TRACK_GATE);
    }

    public function resourceCollectionResponse(Collection $collection): TrackResourceCollection
    {
        return TrackResourceCollection::make($collection);
    }
}