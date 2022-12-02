<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Achievement extends Model
{
    use HasFactory;

    protected $table = 'achievements';

    public static function addAchievement(int $user, string $achievement)
    {
        $userRecord = User::all()->where('id', '=', $user);

        if (!$userRecord) {
            return false;
        }

        $ach = new Achievement();
        $ach->user = $user;
        $ach->achievement = $achievement;

        return $ach->save();
    }

    public function getCreatedAt()
    {
        return Carbon::make($this->created_at)->format('d.m.Y H:i:s');
    }

}
