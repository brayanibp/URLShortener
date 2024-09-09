<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortenedUrl extends Model
{
    use HasFactory;

    /**
     * Defining model primary key as id
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The casted value of id
     * @var string
     */
    protected $casts = [
        'id' => 'string',
    ];

    /**
     * Defining fillable values
     * @var array
     */
    protected $fillable = [
        'original_url',
        'short_url',
        'user_id'
    ];
}
