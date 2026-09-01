<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'group',
        'type',
        'is_encrypted',
    ];

    protected $casts = [
        'is_encrypted' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Type constants
    const TYPE_STRING = 'string';
    const TYPE_INTEGER = 'integer';
    const TYPE_BOOLEAN = 'boolean';
    const TYPE_ARRAY = 'array';
    const TYPE_JSON = 'json';

    // Scopes
    public function scopeByGroup($query, $group)
    {
        return $query->where('group', $group);
    }

    // Accessors
    public function getValueAttribute($value)
    {
        if ($this->is_encrypted) {
            return decrypt($value);
        }

        switch ($this->type) {
            case self::TYPE_INTEGER:
                return (int) $value;
            case self::TYPE_BOOLEAN:
                return (bool) $value;
            case self::TYPE_ARRAY:
            case self::TYPE_JSON:
                return json_decode($value, true);
            default:
                return $value;
        }
    }

    // Mutators
    public function setValueAttribute($value)
    {
        if (is_array($value)) {
            $value = json_encode($value);
        }

        if ($this->is_encrypted) {
            $value = encrypt($value);
        }

        $this->attributes['value'] = (string) $value;
    }

    // Static helper to get setting
    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    // Static helper to set setting
    public static function set($key, $value, $group = 'general', $type = 'string')
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'group' => $group,
                'type' => $type,
            ]
        );
        return $setting;
    }
}
