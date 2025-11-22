<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Course;
use App\Models\CourseDetailes;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;


    protected $guarded = [];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function special()
    {
        return $this->belongsTo(User::class);
    }

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(){
        return asset('images/users/' . $this->image);
    }

    public function refreshTokne()
    {
        return $this->hasMany(RefreshToken::class);
    }



    public function courseDetailes()
    {
        return $this->hasManyThrough(CourseDetailes::class,Course::class,
            'teacher_id',     // مفتاح الربط في جدول courses
            'course_id',      // مفتاح الربط في جدول course_detailes
            'id',             // مفتاح users
            'id'              // مفتاح courses
        );
    }
}
