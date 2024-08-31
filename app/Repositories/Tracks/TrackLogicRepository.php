<?php

declare(strict_types=1);

namespace App\Repositories\Tracks;

use App\Http\Data\Tracks\StoreTrackRequestData;
use App\Http\Data\Tracks\UpdateTrackRequestData;
use App\Models\Track;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Filesystem\FilesystemManager;
use Storage;
use Str;
use TrackNotUploadedException;

class TrackLogicRepository
{
    public function __construct(
        private readonly TrackDbRepository $trackDbRepository,
        private readonly FilesystemManager $storage,
    ) {
    }

    /**
     * @throws TrackNotUploadedException
     */
    public function create(StoreTrackRequestData $data): Track
    {
        return $this->trackDbRepository->create([
            Track::FILE_URL => $this->uploadVerifyAndGetUrl($data),
            Track::NAME => $data->name ?? 'Unknown name',
            Track::ARTIST => $data->artist ?? 'Unknown artist',
            Track::ALBUM => $data->album ?? 'Unknown album',
            Track::GENRE => $data->genre ?? 'Unknown genre',
            Track::YEAR => $data->year ?? 0,
            Track::LENGTH => $data->length ?? 0,
            Track::PLAYS => $data->plays ?? 0,
            Track::RATING => $data->rating ?? 0,
        ]);
    }

    public function show(int $id): Track
    {
        return $this->findOrFail($id);
    }

    public function findOrFail(int $id): Track
    {
        return $this->trackDbRepository->findOrFail($id);
    }

    public function list(): Collection
    {
        return $this->trackDbRepository->list();
    }

    public function update(UpdateTrackRequestData $data): Track
    {
        // dump($data->file);

        return $this->trackDbRepository->update([
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
        return $this->trackDbRepository->delete($id);
    }

    /**
     * @throws TrackNotUploadedException
     */
    private function uploadVerifyAndGetUrl(StoreTrackRequestData $data): string
    {
        $filename = $data->name ?? Str::lower(Str::replace(' ', '-', $data->file->getClientOriginalName()));

        $this->storage->put($filename, $data->file);

        if (!$this->storage->exists($filename)) {
            throw new TrackNotUploadedException;
        }

        return $this->storage->url($filename);
    }
}