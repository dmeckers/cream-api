<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Stations\DeleteStationRequest;
use App\Http\Requests\Stations\GetStationRequest;
use App\Http\Requests\Stations\ListPlaylistsRequest;
use App\Http\Requests\Stations\NextTrackRequest;
use App\Http\Requests\Stations\StartStationRequest;
use App\Http\Requests\Stations\StopStationRequest;
use App\Http\Requests\Stations\StoreStationRequest;
use App\Http\Requests\Stations\UpdateStationRequest;
use App\Models\Track;
use App\Repositories\Stations\RadioStationLogicRepository;
use App\Utils\LaravelGlobals;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StationsController extends Controller
{
    public function __construct(
        private readonly RadioStationLogicRepository $repository,
        private readonly LaravelGlobals $laravelGlobals
    ) {
    }

    public function startStation(StartStationRequest $request)
    {
        $this->repository->startStation($request->data());

        return $this->laravelGlobals->jsonResponse([], Response::HTTP_ACCEPTED);
    }

    public function stopStation(StopStationRequest $request)
    {
        $this->repository->stopStation($request->data());

        return $this->laravelGlobals->jsonResponse([], Response::HTTP_ACCEPTED);
    }

    public function nextTrack(NextTrackRequest $request)
    {
        if (!Track::count()) {
            return response()->json([], Response::HTTP_NOT_FOUND);
        }

        $filePath = collect(Storage::files(Track::latest()->first()->getName()))->first();

        return new StreamedResponse(function () use ($filePath) {
            $stream = Storage::readStream($filePath);
            fpassthru($stream);
            fclose($stream);
        }, Response::HTTP_OK, [
            'Content-Type' => 'audio/mpeg',
            'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"'
        ]);
    }

    public function list(ListPlaylistsRequest $requests)
    {

    }

    public function storeStation(StoreStationRequest $requests)
    {

    }

    public function deleteStation(DeleteStationRequest $requests)
    {

    }

    public function getStation(GetStationRequest $requests)
    {

    }

    public function updateStation(UpdateStationRequest $requests)
    {
    }
}