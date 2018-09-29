<?php

namespace ApiUnicad\Model;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = ['nome'];

    public function entregas()
    {
        return $this->hasMany(Entrega::class, 'cliente_id');
    }
}
