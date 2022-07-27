<?php

namespace App\Models;

use Conner\Likeable\Likeable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class Blog extends Model
{
    use HasFactory, Likeable;

    protected $guarded = ["id"];

    public function author() {
        return $this->belongsTo(
            User::class
        );
    }
    public function category() {
        return $this->belongsTo(
            Category::class
        );
    }

    public function scopeFilter($query, array $filters) {
        $query->when($filters['search'] ?? false, function($query, $search) {
            return $query->where(function($query) use ($search) {
                 $query->where('title', 'like', '%' . $search . '%')
                       ->orWhere('body', 'like', '%' . $search . '%');
            });
        });

        $query->when($filters['category'] ?? false, function($query, $category) { 
            return $query->whereHas("category", function($query) use ($category) {
                $query->where('name',$category);
            });
        });

        $query->when($filters['user'] ?? false, function($query, $user) { 
            return $query->whereHas("user", function($query) use ($user) {
                $query->where('username',$user);
            });
        });
    }
}
