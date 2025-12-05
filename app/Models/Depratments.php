<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depratments extends Model
{
    use HasFactory;
    protected $table = 'depratments';
    protected $fillable = ['title', 'image', 'content'];
}
