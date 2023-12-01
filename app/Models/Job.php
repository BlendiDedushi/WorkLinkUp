<?php

namespace App\Models;

use App\Models\City;
use App\Models\User;
use App\Models\Category;
use App\Models\Schedule;
use App\Models\Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'city_id',
        'category_id',
        'schedule_id',
        'title',
        'description',
        'positions',
        'salary',
        'remote'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function applications(){
        return $this->hasMany(Application::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function schedule(){
        return $this->belongsTo(Schedule::class);
    }

    public function city(){
        return $this->belongsTo(City::class);
    }
}
