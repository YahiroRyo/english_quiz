<?php

namespace App\Models\Quiz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    protected $primaryKey = 'category_id';
    protected $fillable = [
        'name',
        'formal_name',
    ];
}
