<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Response\User\LoginResponse;
use App\Http\Response\User\LogoutResponse;
use Eng\User\Service\Command\LoginService;
use Eng\User\Service\Command\LogoutService;
use Eng\User\Service\Command\RegisterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private LoginService $loginService;
    private LogoutService $logoutService;
    private RegisterService $registerService;

    public function __construct(
        LoginService $loginService,
        LogoutService $logoutService,
        RegisterService $registerService
    ) {
        $this->loginService    = $loginService;
        $this->logoutService   = $logoutService;
        $this->registerService = $registerService;
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $loggedInUser = $this->loginService->execute($request->toDTO());

        return LoginResponse::success($loggedInUser);
    }

    public function logout(Request $request): JsonResponse
    {
        $user = $this->logoutService->execute($request->bearerToken());

        return LogoutResponse::success($user);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $registeredUser = $this->registerService->execute($request->toDTO());

        return LogoutResponse::success($registeredUser);
    }
}
