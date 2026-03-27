<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gnojidba extends Model
{
    protected $table = 'gnojidbe';
    protected $fillable = ['user_id', 'kultura_id', 'datum', 'tip_gnojiva', 'kolicina_kg_ha'];
    protected $casts = ['datum' => 'date'];

    public function user() { return $this->belongsTo(User::class); }
    public function kultura() { return $this->belongsTo(Kultura::class); }
}
