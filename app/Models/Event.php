<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Str;

class Event extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'image',
        'description',
        'location',
        'event_date',
        'price',
        'quota',
        'available_quota',
        'created_by',
    ];
    
    protected static function booted(): void
    {
        static::creating(function ($event) {
            $event->slug = Str::slug($event->title) . '-' . uniqid();
        });

        static::updating(function ($event) {
            if ($event->isDirty('title')) {
                $event->slug = Str::slug($event->title) . '-' . uniqid();
            }
        });
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
