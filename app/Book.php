<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
   	public $table = 'books';

   	protected $fillable = ['name', 'price', 'description', 'cate_id'];
}
