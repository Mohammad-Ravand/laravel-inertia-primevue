<?php

namespace App\Models;

use App\Models\News;
use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    public function newses():BelongsToMany{
        return $this->belongsToMany(News::class);
    }

    public function posts():BelongsToMany{
        return $this->belongsToMany(Post::class);
    }
}
