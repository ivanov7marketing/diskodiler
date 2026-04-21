<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'url',
        'path',
        'disk',
        'alt',
        'sort',
        'is_primary',
    ];

    protected function casts(): array
    {
        return [
            'sort' => 'integer',
            'is_primary' => 'boolean',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    protected static function booted(): void
    {
        static::saving(function (ProductImage $image): void {
            if ($image->path && ! $image->disk) {
                $image->disk = config('filesystems.product_media_disk', 'public');
            }
        });
    }

    public function getMediaUrlAttribute(): ?string
    {
        if ($this->path) {
            try {
                return Storage::disk($this->disk ?: config('filesystems.product_media_disk', 'public'))->url($this->path);
            } catch (Throwable) {
                return $this->url;
            }
        }

        return $this->url;
    }
}
