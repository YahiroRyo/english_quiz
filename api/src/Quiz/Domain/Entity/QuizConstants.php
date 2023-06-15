<?php

namespace Eng\Quiz\Domain\Entity;

class QuizConstants
{
    public const DEFAULT_QUIZ_ID                   = 0;
    public const DEFAULT_QUIZ_SPEECH_ANSWER_URL    = '__NOT_EXISTS__';
    public const DEFAULT_QUIZ_RESPONSE_ID          = 0;
    public const DEFAULT_QUIZ_RESPONSE_REPLY_ID    = 0;
    public const UNRESPONSIVE                      = '__UNRESPONSIVE__';
    public const DECISION_ANSWER_FUNCTION_NAME     = 'dicision_answer';

    public static function createQuizPrompt(string $wordClass): string
    {
        return <<<EOM
        #命令書:
        あなたは、[日本人学生を対象としたアメリカ人プロの英語講師]です。以下の制約条件に基づいて、特定の文法ポイントや語彙テーマに関連する英訳問題を10問作成してください。
        #制約条件:
        - 問題のジャンルは、{$wordClass}を含めた英訳問題（日本語から英語へ翻訳する問題）
        - 英語から日本語へ翻訳する問題は禁止
        - {$wordClass}が含まれていない英文は禁止
        - 問題文は日本語で、問題文の翻訳後が答えになるようにしてください
        - 翻訳後は必ず文にしてください
        - 出力フォーマットは、questionとanswerキーのJSON形式で出力を行い、それらをquizzesキーの配列でラップしてください
        EOM;
    }

    public static function decisionAnswerPrompt(): string
    {
        return <<<EOM
        あなたは、[日本人学生を対象としたアメリカ人プロの英語講師]です。以下の制約条件に基づいて、最高の正否と解説を出力してください。
        EOM;
    }

    public static function decisionAnswerFunctionContent(string $question, string $answer, string $response): string
    {
        return <<<EOM
        # 問題文:
        次の文章を英語に翻訳しなさい。
        「{$question}」
        # 問題の正解:
        {$answer}
        # 回答:
        {$response}
        EOM;
    }

    public static function decisionAnswerFunction(): array
    {
        return [
            'name'        => self::DECISION_ANSWER_FUNCTION_NAME,
            'description' => <<<EOM
            問題文と問題の正解、回答を見比べて、正解か不正解を判定、解説を行う
            EOM,
            'parameters'  => [
               'type'       => 'object',
               'properties' => [
                    'is_correct'  => [
                        'type'        => 'string',
                        'description' => <<<EOM
                        問題文と問題の正解、回答を見比べて、正解か不正解を判定してください。
                        EOM,
                        'enum'        => ['true', 'false'],
                    ],
                    'explanation' => [
                        'type'        => 'string',
                        'description' => <<<EOM
                        問題文と問題の正解、回答を見比べて、正解か不正解を判定した上で、正解だった場合は、褒めなさい。
                        それ以外の場合は、問題文を参考に解説を行いなさい。
                        EOM,
                    ],
               ],
               'required' => ['is_correct', 'explanation']
            ]
        ];
    }
}
