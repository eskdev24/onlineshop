<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public static function avatarUrl($filename)
    {
        if (! $filename) {
            return null;
        }

        $path = 'storage/avatars/'.$filename;

        return asset($path);
    }
}
