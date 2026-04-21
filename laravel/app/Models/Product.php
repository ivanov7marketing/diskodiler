<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class Product extends Model
{
    protected $fillable = [
        'brand_id',
        'vehicle_model_id',
        'slug',
        'title',
        'oem',
        'price',
        'price_label',
        'stock',
        'stock_status',
        'quantity',
        'set_condition',
        'year',
        'size',
        'diameter',
        'width_front',
        'width_rear',
        'et_front',
        'et_rear',
        'pcd',
        'dia',
        'style',
        'color',
        'fitment',
        'specs',
        'description',
        'meta_title',
        'meta_description',
        'h1',
        'seo_text',
        'video_path',
        'video_disk',
        'video_url',
        'video_poster_path',
        'video_poster_disk',
        'video_poster_url',
        'active',
        'sort',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'quantity' => 'integer',
            'active' => 'boolean',
            'sort' => 'integer',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function vehicleModel(): BelongsTo
    {
        return $this->belongsTo(VehicleModel::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort');
    }

    public function primaryImage(): HasOne
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true)->orderBy('sort');
    }

    public function getDisplayPriceAttribute(): string
    {
        if ($this->price_label) {
            return $this->price_label;
        }

        if ($this->price === null) {
            return 'Цена по запросу';
        }

        return number_format($this->price, 0, '.', ' ') . ' ₽';
    }

    public function seoTitle(): string
    {
        if ($this->meta_title) {
            return $this->meta_title;
        }

        $oem = $this->oem ? " OEM {$this->oem}" : '';

        return "{$this->title}{$oem} | ДискоДилер";
    }

    public function seoDescription(): string
    {
        if ($this->meta_description) {
            return $this->meta_description;
        }

        $parts = array_filter([
            $this->description,
            $this->fitment ? "Подходит для {$this->fitment}." : null,
            'Проверка по VIN, OEM-маркировка и доставка по России.',
        ]);

        return Str::limit(trim(implode(' ', $parts)), 165, '');
    }

    public function pageH1(): string
    {
        return $this->h1 ?: $this->title;
    }

    public function getStockStatusLabelAttribute(): string
    {
        return match ($this->stock_status ?: 'in_stock') {
            'in_stock' => 'В наличии',
            'reserved' => 'В резерве',
            'sold' => 'Продано',
            'on_request' => 'Под заказ',
            default => 'Наличие уточняется',
        };
    }

    public function getSetConditionLabelAttribute(): string
    {
        return match ($this->set_condition) {
            'new' => 'Новый комплект',
            'used_excellent' => 'Б/у, отличное состояние',
            'used_good' => 'Б/у, хорошее состояние',
            'refurbished' => 'После восстановления',
            default => 'Состояние уточняется',
        };
    }

    public function getSchemaAvailabilityAttribute(): string
    {
        return match ($this->stock_status) {
            'in_stock' => 'https://schema.org/InStock',
            'reserved' => 'https://schema.org/LimitedAvailability',
            'sold' => 'https://schema.org/OutOfStock',
            'on_request' => 'https://schema.org/PreOrder',
            default => 'https://schema.org/LimitedAvailability',
        };
    }

    public function getSchemaItemConditionAttribute(): string
    {
        return match ($this->set_condition) {
            'new' => 'https://schema.org/NewCondition',
            'refurbished' => 'https://schema.org/RefurbishedCondition',
            default => 'https://schema.org/UsedCondition',
        };
    }

    public function getResolvedVideoUrlAttribute(): ?string
    {
        return $this->storageUrl($this->video_path, $this->video_disk) ?: $this->video_url;
    }

    public function getResolvedVideoPosterUrlAttribute(): ?string
    {
        return $this->storageUrl($this->video_poster_path, $this->video_poster_disk) ?: $this->video_poster_url;
    }

    /**
     * @return array<string, string>
     */
    public function specRows(): array
    {
        return array_filter([
            'Артикул OEM' => $this->oem,
            'Совместимость' => $this->fitment,
            'Параметры' => $this->specs,
            'Диаметр' => $this->diameter ?: $this->size,
            'Ширина перед' => $this->width_front,
            'Ширина зад' => $this->width_rear,
            'ET перед' => $this->et_front,
            'ET зад' => $this->et_rear,
            'PCD' => $this->pcd,
            'DIA' => $this->dia,
            'Стиль' => $this->style,
            'Цвет' => $this->color,
            'Год' => $this->year,
            'Состояние' => $this->set_condition_label,
            'Наличие' => $this->stock ?: $this->stock_status_label,
            'Марка' => $this->brand?->name,
            'Модель' => $this->vehicleModel?->name,
        ]);
    }

    protected static function booted(): void
    {
        static::saving(function (Product $product): void {
            $mediaDisk = config('filesystems.product_media_disk', 'public');

            if ($product->video_path && ! $product->video_disk) {
                $product->video_disk = $mediaDisk;
            }

            if ($product->video_poster_path && ! $product->video_poster_disk) {
                $product->video_poster_disk = $mediaDisk;
            }
        });
    }

    private function storageUrl(?string $path, ?string $disk): ?string
    {
        if (! $path) {
            return null;
        }

        try {
            return Storage::disk($disk ?: config('filesystems.product_media_disk', 'public'))->url($path);
        } catch (Throwable) {
            return null;
        }
    }
}
