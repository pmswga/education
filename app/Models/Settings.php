<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Settings extends Model
{
    use HasFactory;

    protected $table = 'settings';

    public static function getSettings()
    {
        return Settings::all()->first();
    }

    public static function getTitle()
    {
        $settings = Settings::all()->first();

        return $settings->title;
    }

}
