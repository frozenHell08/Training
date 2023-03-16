<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'reference_no',
        'sender',
        'receiver',
        'amount',
        'type', 
    ];

    public function users() {
        return $this->belongsToMany(User::class, 'id');
    }
}
