<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    public const TYPE_OPTIONS = [
        'lead' => 'Заявка',
        'vin_selection' => 'VIN-подбор',
        'wheel_quiz' => 'Квиз',
    ];

    public const STATUS_OPTIONS = [
        'new' => 'Новая',
        'in_progress' => 'В работе',
        'contacted' => 'Связались',
        'no_answer' => 'Не дозвонились',
        'done' => 'Закрыта',
    ];

    public const STATUS_COLORS = [
        'new' => 'warning',
        'in_progress' => 'info',
        'contacted' => 'success',
        'no_answer' => 'danger',
        'done' => 'gray',
    ];

    public const CONTACT_METHOD_OPTIONS = [
        'Telegram' => 'Telegram',
        'Max' => 'Max',
        'Звонок' => 'Звонок',
        'Позвонить' => 'Позвонить',
        'WhatsApp' => 'WhatsApp',
    ];

    public const TRAFFIC_CHANNEL_OPTIONS = [
        'seo' => 'SEO',
        'direct' => 'РџСЂСЏРјРѕР№',
        'yandex_direct' => 'Р”РёСЂРµРєС‚',
        'other' => 'Р”СЂСѓРіРёРµ',
    ];

    public const TRAFFIC_CHANNEL_COLORS = [
        'seo' => 'info',
        'direct' => 'success',
        'yandex_direct' => 'warning',
        'other' => 'gray',
    ];

    protected $fillable = [
        'type',
        'status',
        'name',
        'phone',
        'contact_method',
        'telegram',
        'vin',
        'message',
        'manager_comment',
        'handled_at',
        'source_page',
        'referer_url',
        'referer_host',
        'traffic_channel',
        'goal',
        'utm',
        'payload',
    ];

    protected function casts(): array
    {
        return [
            'handled_at' => 'datetime',
            'utm' => 'array',
            'payload' => 'array',
        ];
    }

    public function getTypeLabelAttribute(): string
    {
        return self::TYPE_OPTIONS[$this->type] ?? $this->type ?? 'Заявка';
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_OPTIONS[$this->status] ?? $this->status ?? 'Новая';
    }

    public function getContactMethodLabelAttribute(): string
    {
        return self::CONTACT_METHOD_OPTIONS[$this->contact_method] ?? $this->contact_method ?? 'Не указан';
    }

    public static function statusColor(?string $status): string
    {
        return self::STATUS_COLORS[$status] ?? 'gray';
    }

    public function getTrafficChannelLabelAttribute(): string
    {
        return self::TRAFFIC_CHANNEL_OPTIONS[$this->traffic_channel] ?? $this->traffic_channel ?? 'РќРµ РѕРїСЂРµРґРµР»РµРЅРѕ';
    }

    public static function trafficChannelColor(?string $channel): string
    {
        return self::TRAFFIC_CHANNEL_COLORS[$channel] ?? 'gray';
    }
}
