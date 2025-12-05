<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagegallery extends Model
{
    use HasFactory;
    protected $table = 'imagegallery';
    protected $fillable = ['image'];
}
