<?php

namespace App\Http\Controllers;

use App\Http\Requests\Quiz\AddMessageRequest;
use App\Http\Requests\Quiz\CreateQuizRequest;
use App\Http\Requests\Quiz\GetQuizListRequest;
use App\Http\Response\Quiz\AddMessageResponse;
use App\Http\Response\Quiz\CreateQuizListResponse;
use App\Http\Response\Quiz\GetQuizListResponse;
use App\Http\Response\Quiz\GetQuizResponse;
use App\Http\Response\Quiz\QuizCategoryListResponse;
use App\Http\Response\Quiz\QuizCategoryResponse;
use Carbon\CarbonImmutable;
use Eng\Quiz\Domain\DTO\AddMessageToQuizDTO;
use Eng\Quiz\Service\Command\AddMessageService;
use Eng\Quiz\Service\Command\CreateQuizService;
use Eng\Quiz\Service\Query\GetQuizListService;
use Eng\Quiz\Service\Query\GetQuizService;
use Eng\Quiz\Service\Query\QuizCategoryListService;
use Eng\Quiz\Service\Query\QuizCategoryService;
use Illuminate\Http\JsonResponse;

class QuizController extends Controller
{
    private QuizCategoryListService $quizCategoryListService;
    private QuizCategoryService $quizCategoryService;
    private CreateQuizService $createQuizService;
    private GetQuizListService $getQuizListService;
    private GetQuizService $getQuizService;
    private AddMessageService $addMessageService;

    public function __construct(
        QuizCategoryListService $quizCategoryListService,
        QuizCategoryService $quizCategoryService,
        CreateQuizService $createQuizService,
        GetQuizListService $getQuizListService,
        GetQuizService $getQuizService,
        AddMessageService $addMessageService
    ) {
        $this->quizCategoryListService = $quizCategoryListService;
        $this->quizCategoryService = $quizCategoryService;
        $this->createQuizService = $createQuizService;
        $this->getQuizListService = $getQuizListService;
        $this->getQuizService = $getQuizService;
        $this->addMessageService = $addMessageService;
    }

    public function categoryList(): JsonResponse
    {
        $quizCategoryList = $this->quizCategoryListService->execute();

        return QuizCategoryListResponse::success($quizCategoryList);
    }

    public function category(string $quizCategoryId): JsonResponse
    {
        $quizCategory = $this->quizCategoryService->execute(intval($quizCategoryId));

        return QuizCategoryResponse::success($quizCategory);
    }

    public function createQuiz(CreateQuizRequest $request): JsonResponse
    {
        $quizList = $this->createQuizService->execute($request->validated('quizCategoryId'));

        return CreateQuizListResponse::success($quizList);
    }

    public function getQuizList(GetQuizListRequest $request): JsonResponse
    {
        $searchedQuizList = $this->getQuizListService->execute($request->toDTO());

        return GetQuizListResponse::success($searchedQuizList);
    }

    public function getQuiz(string $quizId): JsonResponse
    {
        $quiz = $this->getQuizService->execute(intval($quizId));

        return GetQuizResponse::success($quiz);
    }

    public function addMessage(AddMessageRequest $request, int $quizId): JsonResponse
    {
        $quiz = $this->addMessageService->execute(AddMessageToQuizDTO::from(
            $quizId,
            $request->validated('message'),
            CarbonImmutable::now(),
        ));

        return AddMessageResponse::success($quiz);
    }
}
