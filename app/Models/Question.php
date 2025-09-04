<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Question extends Model
{
    use HasFactory;
    protected $fillable = ['question_text','type_of_question'];

    public function choices()
    {
        return $this->hasMany(Choice::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }
}
