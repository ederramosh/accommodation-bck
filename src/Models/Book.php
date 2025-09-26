<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    protected $table = 'books';
    public $timestamps = false;
    protected $primaryKey = 'id_books';
    protected $fillable = ['id_user', 'id_accommodation', 'reservation', 'created_at'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function accommodation(): BelongsTo
    {
        return $this->belongsTo(Accommodation::class, 'id_accommodation', 'id');
    }
}
