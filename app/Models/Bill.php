<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = ['application_id', 'subtotal', 'gst', 'grand_total'];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function billItems()
    {
        return $this->hasMany(BillItem::class);
    }
}
