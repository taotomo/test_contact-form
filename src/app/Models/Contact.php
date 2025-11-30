<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $fillable = [
        'category_id',
        'first_name',
        'last_name',
        'gender',
        'email',
        'tel',
        'address',
        'building',
        'detail',
    ];

    public static $rules = array(
        'category_id' => 'integer|min:1|max:5',
        'gender' => 'integer|min:1|max:3',
        'email' => 'email',
        'tel' => 'tel',
    );

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
}
