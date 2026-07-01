<?php

// Sample Book model for Demo 1 and Demo 4
// Synthetic example — use for demo only

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'isbn',
        'published_year',
    ];

    protected $casts = [
        'published_year' => 'integer',
    ];
}
