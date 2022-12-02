<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $table = 'lessons';

    public function getCourse()
    {
        return $this->hasOne(Course::class, 'id', 'course')->first();
    }
}
