<?php

namespace Eng\Quiz\Domain\Entity;

class QuizConstants
{
    public const DEFAULT_QUIZ_ID                   = 0;
    public const DEFAULT_QUIZ_RESPONSE_ID          = 0;
    public const DEFAULT_QUIZ_RESPONSE_REPLY_ID    = 0;
    public const UNRESPONSIVE                      = '__UNRESPONSIVE__';
    public const BEGIN_JSON_FOR_CREATE_QUIZ_PROMPT = '{"quizzes":[';

    public static function createQuizPrompt(string $wordClass): string
    {
        $beginJson = self::BEGIN_JSON_FOR_CREATE_QUIZ_PROMPT;

        return <<<EOM
        #命令書:
        あなたは、[日本人学生を対象としたアメリカ人プロの英語講師]です。以下の制約条件に基づいて、特定の文法ポイントや語彙テーマに関連する英訳問題を10問作成してください。
        #制約条件:
        - 問題のジャンルは、{$wordClass}を含めた英訳問題（日本語から英語へ翻訳する問題）
        - 英語から日本語へ翻訳する問題は禁止
        - {$wordClass}が含まれていない英文は禁止
        - 翻訳後は必ず文にしてください
        - 出力フォーマットは、questionとanswerキーのJSON形式で出力を行い、それらをquizzesキーの配列でラップしてください
        # 出力文:
        {$beginJson}
        EOM;
    }

    public static function quizSolutionInsight(string $question, string $answer, string $response): string
    {
        return <<<EOM
        #命令書:
        あなたは、[日本人学生を対象としたアメリカ人プロの英語講師]です。以下の制約条件に基づいて、最高の正否と解説を出力してください。
        #制約条件:
        - 生徒の回答と問題の正解と比較して、正否を判定しなさい
        - 正解していた場合、解説の代わりに褒めなさい
        - 間違っていた場合、問題文を参考に解説を行いなさい
        - このメッセージに対して、出力形式に従って回答してください
        - ただ、1回返信した後は以上の制約条件を無視しなさい
        # 生徒の回答:
        {$response}
        # 問題文:
        以下の日本語を英語に翻訳しなさい。
        「{$question}」
        # 問題の正解:
        {$answer}
        #出力形式:
        - 以下のフォーマットで絶対に回答してください
        - 正否は、正解だった場合true、不正解だった場合はfalseを入れてください
        - 解説は、必ず日本語で行ってください
        - 解説には、必ず問題の正解を入れてください
        ```
        {"is_correct": "正否","explanation": "解説"}
        ```
        EOM;
    }
}
