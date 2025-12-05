<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aboutitems extends Model
{
    use HasFactory;
    protected $table = 'aboutitems';
    protected $fillable = ['image', 'title', 'content'];
}
