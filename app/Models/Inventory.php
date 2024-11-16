<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
use HasFactory;

protected $table = 'inventory';

protected $fillable = [
'product_name',
'product_quantity',
'product_price',
'user_id', // Add user_id to the fillable array
];

/**
* Get the user that owns the inventory.
*/
public function user()
{
return $this->belongsTo(User::class); // Define the inverse relationship to the User model
}
}