<?php

declare(strict_types=1);

namespace App\Repositories\Tracks;

use App\Data\Tracks\CreateTrackRequestData;
use App\Data\Tracks\UpdateTrackRequestData;
use App\Models\Track;
use Illuminate\Database\Eloquent\Collection;

class TrackLogicRepository
{
    public function __construct(private readonly TrackDbRepostiory $trackDbRepostiory)
    {
    }

    public function create(CreateTrackRequestData $data): Track
    {
        // Track::FILE => $data->file->store('tracks'),

        return $this->trackDbRepostiory->create([
            Track::NAME => $data->name,
            Track::ARTIST => $data->artist,
            Track::ALBUM => $data->album,
            Track::GENRE => $data->genre,
            Track::YEAR => $data->year,
            Track::LENGTH => $data->length,
            Track::PLAYS => $data->plays,
            Track::RATING => $data->rating,
        ]);
    }

    public function show(int $id): Track
    {
        return $this->findOrFail($id);
    }

    public function findOrFail(int $id): Track
    {
        return $this->trackDbRepostiory->findOrFail($id);
    }

    public function list(): Collection
    {
        return $this->trackDbRepostiory->list();
    }

    public function update(UpdateTrackRequestData $data): Track
    {
        // dump($data->file);

        return $this->trackDbRepostiory->update([
            Track::NAME => $data->name,
            Track::ARTIST => $data->artist,
            Track::ALBUM => $data->album,
            Track::GENRE => $data->genre,
            Track::YEAR => $data->year,
            Track::LENGTH => $data->length,
            Track::PLAYS => $data->plays,
            Track::RATING => $data->rating,
        ], $data->id);
    }

    public function delete(int $id): ?bool
    {
        return $this->trackDbRepostiory->delete($id);
    }
}