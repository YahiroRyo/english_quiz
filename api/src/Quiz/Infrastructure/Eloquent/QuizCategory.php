<?php

namespace Eng\Quiz\Infrastructure\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizCategory extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    protected $primaryKey = 'quiz_category_id';
    protected $fillable = [
        'name',
        'formal_name',
    ];

    public function getQuizCategoryId(): int
    {
        return $this->quiz_category_id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getFormalName(): string
    {
        return $this->formal_name;
    }
}
