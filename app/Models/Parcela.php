<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parcela extends Model
{
    protected $table = 'parcele';
    protected $fillable = ['user_id', 'arkod_broj', 'povrsina_ha'];

    public function user() { return $this->belongsTo(User::class); }
    public function kulture() { return $this->hasMany(Kultura::class); }
}
