<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    protected $table = 'users';
    public $timestamps = false;
    protected $fillable = ['name', 'email', 'password', 'rol'];

    public function books(): HasMany
    {
        return $this->hasMany(Book::class, 'id_user', 'id');
    }
}
