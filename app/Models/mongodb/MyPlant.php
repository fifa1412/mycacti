<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class MyPlantMongo extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'my_plant';
    
    protected $fillable = [
        'plant_id',
        'plant_name',
        'user_id',
        'price',
        'img_name',
        'thumbnail_img_name',
        'img_cloud_path',
        'thumbnail_img_cloud_path',
        'plant_status_id',
        'received_date',
        'note',
    ];
    
}
