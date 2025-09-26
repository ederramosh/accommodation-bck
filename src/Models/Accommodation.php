<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Accommodation extends Model
{
    protected $table = 'accommodation';
    public $timestamps = false;
    protected $fillable = ['name', 'address', 'price', 'description', 'available', 'imageUrl'];

    public function books(): HasMany
    {
        return $this->hasMany(Book::class, 'id_accommodation', 'id');
    }
}
