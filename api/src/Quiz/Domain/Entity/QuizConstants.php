<?php

namespace Eng\Quiz\Domain\Entity;

class QuizConstants
{
    public const DEFAULT_QUIZ_ID    = 0;
    public const UNRESPONSIVE       = '__UNRESPONSIVE__';

    public static function createQuizPrompt(string $wordClass): string
    {
        return <<<EOM
        #命令書:
        あなたは、[日本人学生を対象としたアメリカ人プロの英語講師]です。以下の制約条件に基づいて、特定の文法ポイントや語彙テーマに関連する英訳問題を10問作成してください。

        #制約条件:
        - 問題のジャンルは、{$wordClass}を含めた英訳問題。（日本語から英語へ翻訳する問題）
        - 英語から日本語へ翻訳する問題は禁止。
        - {$wordClass}が含まれていない英文は禁止。
        - 翻訳後は必ず文にしてください。
        - 出力フォーマットは、questionとanswerキーのJSON形式で出力を行い、それらを配列でラップしてください。
        EOM;
    }
}
