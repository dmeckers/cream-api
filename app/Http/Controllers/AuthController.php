<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Http\Requests\Auth\TelegramAuthRequest;
use App\Models\TelegramUser;
use Illuminate\Auth\AuthManager;
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
        private readonly AuthManager $auth,
    ) {
    }

    public function me(): TelegramUser
    {
        return $this->laravelGlobals->user();
    }

    public function refresh(TelegramAuthRequest $request): JsonResponse
    {
        try {
            $response = $this->laravelGlobals->jsonResponse([
                $this->userLogicRepository
                    ->signInOrSignUpViaTelegram($request->data())
                    ->createToken('auth_token')
                    ->plainTextToken
            ]);

            \Log::info('response', ['response' => $response]);
            return $response;
        } catch (\Throwable $th) {
            \Log::error($th->getMessage(), ['context' => $th->getTrace()]);

            return $this->laravelGlobals->jsonResponse([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Shit below is for non telegram users but for very few users
     */
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