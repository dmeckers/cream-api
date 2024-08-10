<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\Users\UserLogicRepository;
use App\Requests\Auth\RegisterUserRequest;
use App\Utils\LaravelGlobals;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        private readonly UserLogicRepository $userLogicRepository,
        private readonly LaravelGlobals $laravelGlobals,
    ) {
    }

    public function register(RegisterUserRequest $request): JsonResponse
    {
        return $this->laravelGlobals->jsonResponse([
            'token' => $this->userLogicRepository->create($request->data())
        ]);
    }
}
