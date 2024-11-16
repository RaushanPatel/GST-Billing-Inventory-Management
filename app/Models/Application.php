<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
use HasFactory;

protected $fillable = [
'title',
'description',
'date',
'to',
'subject',
'user_id', // Add user_id to fillable
];

/**
* Get the user that owns the application.
*/
public function user()
{
return $this->belongsTo(User::class); // Define the relationship to the User model
}

/**
* Get the bills for the application.
*/
public function bills()
{
return $this->hasMany(Bill::class);
}
}