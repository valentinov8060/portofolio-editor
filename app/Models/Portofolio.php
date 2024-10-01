<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portofolio extends Model
{
    use HasFactory;

    protected $table = 'portofolio';
    protected $primaryKey = 'id'; 
    protected $fillable = ['name', 'profession', 'profile_picture', 'mime_type', 'about', 'skills', 'projects', 'contacts'];
}
