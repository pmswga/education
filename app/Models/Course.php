<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';

    public function getLessons()
    {
        return $this->hasMany(Lesson::class, 'course', 'id')->get();
    }

    public function getImageSrc()
    {
        return Storage::url('cover/' .  basename($this->image));
    }

    public function getTests()
    {
        return $this->hasMany(Test::class, 'course', 'id')->get();
    }

}
