<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    use HasFactory;

    protected $table = 'inventory_item'; // Make sure to match your table name

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'name',
        'section',
        'price',
        'description',
        'image',
    ];

    // If you have any relationships, define them here
}
