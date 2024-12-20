<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    // If your table name is 'items' (plural), you can skip this, but if it's different, you can specify it here
    protected $table = 'inventory_item'; // replace with your table name

    // Define the columns that are mass assignable
    protected $fillable = ['name', 'section', 'image', 'price', 'description'];  // Add your table columns here
}
