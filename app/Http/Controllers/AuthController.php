<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use Illuminate\Http\Response;
use App\Repositories\Users\UserLogicRepository;
use App\Utils\LaravelGlobals;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    public function __construct(
        private readonly UserLogicRepository $userLogicRepository,
        private readonly LaravelGlobals $laravelGlobals,
    ) {
    }

    public function refreshCookies(): Response
    {
        return new Response('', Response::HTTP_NO_CONTENT);
    }

    public function register(RegisterUserRequest $request): JsonResponse
    {
        return $this->laravelGlobals->jsonResponse([
            'token' => $this->userLogicRepository->create($request->data())
        ]);
    }

    public function login(LoginUserRequest $request): JsonResponse
    {
        return $this->laravelGlobals->jsonResponse([
            'token' => $this->userLogicRepository->login($request->data())
        ]);
    }
}