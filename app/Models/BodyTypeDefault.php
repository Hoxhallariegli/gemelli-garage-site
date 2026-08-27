<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BodyTypeDefault extends Model
{
    protected $fillable = ['body_type', 'model_3d_path', 'image_2d_path'];
}
