<?php

namespace App\Http\Controllers;

use App\Http\Response\Quiz\QuizCategoryListResponse;
use Eng\Quiz\Service\Query\QuizCategoryListService;
use Illuminate\Http\JsonResponse;

class QuizController extends Controller
{
    private QuizCategoryListService $quizCategoryListService;

    public function __construct(QuizCategoryListService $quizCategoryListService)
    {
        $this->quizCategoryListService = $quizCategoryListService;
    }

    public function categoryList(): JsonResponse
    {
        $quizCategoryList = $this->quizCategoryListService->execute();

        return QuizCategoryListResponse::success($quizCategoryList);
    }
}
