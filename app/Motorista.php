<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Motorista extends Model
{
    protected $fillable = ['nome','cpf','email','situacao','status'];
}
