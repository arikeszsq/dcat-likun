<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public function setFilesAttribute($files)
    {
        if (is_array($files)) {
            $this->attributes['files'] = json_encode($files);
        }
    }

    public function getFilesAttribute($files)
    {
        return $files ? json_decode($files, true) : [];
    }
}
