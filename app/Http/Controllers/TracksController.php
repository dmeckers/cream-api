<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\TrackResource;
use App\Http\Resources\TrackResourceCollection;
use App\Repositories\Tracks\TrackLogicRepository;
use App\Requests\Tracks\CreateTrackRequest;
use App\Requests\Tracks\GetTrackRequest;
use App\Requests\Tracks\ListTrackRequest;
use App\Requests\Tracks\UpdateTrackRequest;
use App\Utils\LaravelGlobals;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TracksController extends Controller
{
    public function __construct(
        private readonly TrackLogicRepository $trackLogicRepository,
        private readonly LaravelGlobals $laravelGlobals,
    ) {
    }

    public function index(ListTrackRequest $request): TrackResourceCollection
    {
        return $request->resourceCollectionResponse($this->trackLogicRepository->list());
    }

    public function store(CreateTrackRequest $request): TrackResource
    {
        return $request->resourceResponse($this->trackLogicRepository->create($request->data()));
    }

    public function show(GetTrackRequest $request): TrackResource
    {
        return $request->resourceResponse($this->trackLogicRepository->show($request->getTrackId()));
    }

    public function update(UpdateTrackRequest $request): TrackResource
    {
        return $request->resourceResponse($this->trackLogicRepository->update($request->data()));
    }

    public function destroy(int $id): JsonResponse
    {
        return $this->laravelGlobals->jsonResponse(
            [
                'deleted' => $this->trackLogicRepository->delete($id)
            ],
            Response::HTTP_NO_CONTENT
        );
    }

    // public function search(SearchTrackRequest $request): JsonResponse
    // {
    //     return $this->trackLogicRepository->search($request->data());
    // }
}