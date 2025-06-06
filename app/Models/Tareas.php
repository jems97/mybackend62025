<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Tareas extends Model
{
    protected $fillable = ['titulo', 'descripcion', 'fecha_limite', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
