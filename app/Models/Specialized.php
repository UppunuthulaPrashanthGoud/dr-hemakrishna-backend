<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialized extends Model
{
    use HasFactory;
    protected $table = 'specialized';
    protected $fillable = ['image', 'title', 'content'];
}
