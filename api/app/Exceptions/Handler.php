<?php

namespace App\Exceptions;

use App\Http\Response\Response;
use Eng\Aws\Infrastructure\Repository\Exception\FailUploadFileException;
use Eng\Quiz\Service\Exception\AlreadyCreatingQuizException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof ValidationException) {
            return Response::error('バリデーションエラーが発生しました。', $e->errors(), 400);
        }
        if ($e instanceof AccessDeniedHttpException) {
            return Response::error('認証に失敗しました。', null, 403);
        }
        if ($e instanceof AlreadyCreatingQuizException) {
            return Response::error('既にクイズは作成中のため、しばらくお待ち頂いた後、ページをロードしてください。', null, 429);
        }
        if ($e instanceof FailUploadFileException) {
            return Response::error('ファイルのアップロードに失敗しました。', null, 500);
        }

        return parent::render($request, $e);
    }
}
