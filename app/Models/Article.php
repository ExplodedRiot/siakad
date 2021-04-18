<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\ArticleController;
Route::resource('articles', ArticleController::class);

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'featured_image'
    ];
}
