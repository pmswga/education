<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    protected $table = 'tests';

    public function getCourse()
    {
        return $this->hasOne(Course::class, 'id', 'course')->first();
    }

    public function getQuestions()
    {
        $questions = explode('&', $this->questions);

        return $questions;
    }

    public function getCreatedAt()
    {
        return $this->created_at->format('d.m.Y H:i:s');
    }

}
