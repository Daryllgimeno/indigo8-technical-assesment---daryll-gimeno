<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Question extends Model
{
    protected $fillable = ['question_text'];

    public function choices()
    {
        return $this->hasMany(Choice::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }
}
