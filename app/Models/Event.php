<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'organizer_id',
        'category_id',
        'name',
        'description',
        'location',
        'start_date',
        'end_date',
        'max_participants',
        'available_slots',
        'status',
    ];

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

   
public function isRegisteredByUser($userId)
{
    return $this->registrations()->where('user_id', $userId)->exists();
}
}