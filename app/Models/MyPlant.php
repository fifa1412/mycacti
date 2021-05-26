<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class MyPlant extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'my_plant';
    
    protected $fillable = [
        'plant_id',
        'plant_name',
        'user_id',
        'price',
        'img_name',
        'cloud_img_url',
        'plant_status_id',
        'received_date',
        'note',
    ];
    
}
