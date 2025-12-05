<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Firstgallery extends Model
{
    use HasFactory;
    protected $table = 'firstgallery';
    protected $fillable = ['image'];
}
