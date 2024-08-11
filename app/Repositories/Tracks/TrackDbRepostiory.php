<?php

declare(strict_types=1);

namespace App\Repositories\Tracks;

use App\Models\Track;
use Illuminate\Database\Eloquent\Collection;

class TrackDbRepostiory
{
    public function __construct(private readonly Track $track)
    {
    }

    public function create(array $data): Track
    {
        return $this->track->create($data);
    }

    public function findOrFail(int $id): Track
    {
        return $this->track->findOrFail($id);
    }

    public function list(): Collection
    {
        return $this->track->get();
    }

    public function update(array $data, int $id): Track
    {
        $track = $this->findOrFail($id);
        $track->update($data);

        return $track;
    }

    public function delete(int $id): ?bool
    {
        return $this->findOrFail($id)->delete();
    }

    // public function search(array $data): Collection
}