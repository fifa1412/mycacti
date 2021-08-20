<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CloudImageDetails extends Model
{
    use HasFactory;

    protected $table = 'cloud_image_details';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'location',
        'img_name',
        'thumbnail_img_name',
        'date_taken',
        'img_cloud_path',
        'thumbnail_img_cloud_path',
        'is_available',
        'is_deleted',
    ];
}
