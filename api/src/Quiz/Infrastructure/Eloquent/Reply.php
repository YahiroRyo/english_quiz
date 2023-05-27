<?php

namespace Eng\Quiz\Infrastructure\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    protected $primaryKey = 'reply_id';
    protected $fillable = [
        'message',
        'response_id',
    ];
}
