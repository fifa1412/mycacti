<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyPlant extends Model
{
    use HasFactory;

    protected $table = 'my_plant';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'plant_name',
        'price',
        'img',
        'plant_status_id',
        'received_date',
        'note'
    ];

}
