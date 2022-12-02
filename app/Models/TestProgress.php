<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestProgress extends Model
{
    use HasFactory;

    protected $table = 'tests_progress';

    public function getUser()
    {
        return $this->hasOne(User::class, 'id', 'user')->first();
    }

    public function getTest()
    {
        return $this->hasOne(Test::class, 'id', 'test')->first();
    }

    public function getAnswers()
    {
        $answers = explode('&', $this->answers);

        return $answers;
    }

}
