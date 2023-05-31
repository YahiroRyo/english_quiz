<?php

namespace App\Http\Controllers;

use App\Http\Requests\Quiz\CreateQuizRequest;
use App\Http\Response\Quiz\CreateQuizListResponse;
use App\Http\Response\Quiz\QuizCategoryListResponse;
use App\Http\Response\Quiz\QuizCategoryResponse;
use Eng\Quiz\Service\Command\CreateQuizService;
use Eng\Quiz\Service\Query\QuizCategoryListService;
use Eng\Quiz\Service\Query\QuizCategoryService;
use Illuminate\Http\JsonResponse;

class QuizController extends Controller
{
    private QuizCategoryListService $quizCategoryListService;
    private QuizCategoryService $quizCategoryService;
    private CreateQuizService $createQuizService;

    public function __construct(
        QuizCategoryListService $quizCategoryListService,
        QuizCategoryService $quizCategoryService,
        CreateQuizService $createQuizService
    ) {
        $this->quizCategoryListService = $quizCategoryListService;
        $this->quizCategoryService = $quizCategoryService;
        $this->createQuizService = $createQuizService;
    }

    public function categoryList(): JsonResponse
    {
        $quizCategoryList = $this->quizCategoryListService->execute();

        return QuizCategoryListResponse::success($quizCategoryList);
    }

    public function category(int $quizCategoryId): JsonResponse
    {
        $quizCategory = $this->quizCategoryService->execute($quizCategoryId);

        return QuizCategoryResponse::success($quizCategory);
    }

    public function createQuiz(CreateQuizRequest $request): JsonResponse
    {
        $quizList = $this->createQuizService->execute($request->validated()['quizCategoryId']);

        return CreateQuizListResponse::success($quizList);
    }

    public function getQuizList(): JsonResponse
    {
    }
}
