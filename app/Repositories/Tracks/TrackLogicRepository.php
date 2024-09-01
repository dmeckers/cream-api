<?php

declare(strict_types=1);

namespace App\Repositories\Tracks;

use App\Exceptions\Tracks\TrackNotUploadedException;
use App\Http\Data\Tracks\StoreTrackRequestData;
use App\Http\Data\Tracks\UpdateTrackRequestData;
use App\Models\Track;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Support\Facades\Log;
use Str;

class TrackLogicRepository
{
    public function __construct(
        private readonly TrackDbRepository $trackDbRepository,
        private readonly FilesystemManager $storage,
    ) {
    }

    /**
     * @throws TrackNotUploadedException
     * @throws Exception
     */
    public function create(StoreTrackRequestData $data): Track
    {
        return $this->trackDbRepository->create([
            Track::FILE_URL => $this->uploadVerifyAndGetUrl($data),
            Track::NAME => $data->name ?? $this->getFileName($data),
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

    public function delete(int $id): bool
    {
        $track = $this->trackDbRepository->findOrFail($id);

        foreach ($this->storage->files($track->getName()) as $file) {

            $deleted = $this->storage->delete($file);

            Log::info('deleted', ['deleted' => $deleted]);

            if ($this->storage->exists($track->getFileUrl())) {
                throw new Exception('Track failed to delete');
            }
        }

        $this->trackDbRepository->delete($id);

        return !$this->trackDbRepository->existsByName($track->getName());
    }

    /**
     * @throws TrackNotUploadedException
     * @throws Exception
     */
    private function uploadVerifyAndGetUrl(StoreTrackRequestData $data): string
    {
        $filename = $this->getFileName($data);

        /**
         * @todo Remove later as it will be divided on stations with their own tracks that may have the same name
         * @todo multitenancy for each station? 80% sure that no
         */
        if ($this->trackDbRepository->existsByName($filename) || $this->storage->exists($filename)) {
            throw new Exception('Track already exists');
        }

        $this->storage->put($filename, $data->file);

        if (!$this->storage->exists($filename)) {
            throw new TrackNotUploadedException;
        }

        return $this->storage->url($filename);
    }

    private function getFileName(StoreTrackRequestData $data): string
    {
        return $data->name ?? Str::lower(Str::replace(' ', '-', $data->file->getClientOriginalName()));
    }
}