<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiConfiguration extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'config',
        'type',
        'is_active',
        'parameters',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'config' => 'array',
        'parameters' => 'array',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ============ CONSTANTS ============

    /**
     * AI Configuration Types
     */
    const TYPE_MATCHING = 'matching';
    const TYPE_SCORING = 'scoring';
    const TYPE_RANKING = 'ranking';
    const TYPE_PARSING = 'parsing';

    const TYPES = [
        self::TYPE_MATCHING,
        self::TYPE_SCORING,
        self::TYPE_RANKING,
        self::TYPE_PARSING,
    ];

    // ============ RELATIONSHIPS ============

    /**
     * Get the applications that use this AI configuration.
     */
    public function applications()
    {
        return $this->hasMany(Application::class, 'ai_configuration_id');
    }

    /**
     * Get the job posts that use this AI configuration.
     */
    public function jobPosts()
    {
        return $this->hasMany(JobPost::class, 'ai_configuration_id');
    }

    // ============ SCOPES ============

    /**
     * Scope a query to only include active configurations.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include configurations by type.
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope a query to only include matching configurations.
     */
    public function scopeMatching($query)
    {
        return $query->where('type', self::TYPE_MATCHING);
    }

    /**
     * Scope a query to only include scoring configurations.
     */
    public function scopeScoring($query)
    {
        return $query->where('type', self::TYPE_SCORING);
    }

    /**
     * Scope a query to only include ranking configurations.
     */
    public function scopeRanking($query)
    {
        return $query->where('type', self::TYPE_RANKING);
    }

    /**
     * Scope a query to only include parsing configurations.
     */
    public function scopeParsing($query)
    {
        return $query->where('type', self::TYPE_PARSING);
    }

    /**
     * Scope a query to search by name or description.
     */
    public function scopeSearch($query, $searchTerm)
    {
        return $query->where('name', 'LIKE', "%{$searchTerm}%")
                     ->orWhere('description', 'LIKE', "%{$searchTerm}%");
    }

    // ============ ACCESSORS ============

    /**
     * Get the type label.
     */
    public function getTypeLabelAttribute()
    {
        return ucfirst($this->type);
    }

    /**
     * Get the status label.
     */
    public function getStatusLabelAttribute()
    {
        return $this->is_active ? 'Active' : 'Inactive';
    }

    /**
     * Get formatted configuration for display.
     */
    public function getFormattedConfigAttribute()
    {
        return json_encode($this->config, JSON_PRETTY_PRINT);
    }

    /**
     * Get a specific config value by key.
     */
    public function getConfigValue($key, $default = null)
    {
        return $this->config[$key] ?? $default;
    }

    /**
     * Get a specific parameter value by key.
     */
    public function getParameter($key, $default = null)
    {
        return $this->parameters[$key] ?? $default;
    }

    // ============ MUTATORS ============

    /**
     * Set the slug attribute.
     */
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = \Str::slug($value);
    }

    /**
     * Set the config attribute.
     */
    public function setConfigAttribute($value)
    {
        if (is_string($value)) {
            $value = json_decode($value, true);
        }
        $this->attributes['config'] = json_encode($value);
    }

    /**
     * Set the parameters attribute.
     */
    public function setParametersAttribute($value)
    {
        if (is_string($value)) {
            $value = json_decode($value, true);
        }
        $this->attributes['parameters'] = json_encode($value);
    }

    // ============ HELPER METHODS ============

    /**
     * Activate the configuration.
     */
    public function activate()
    {
        $this->is_active = true;
        $this->save();
        return $this;
    }

    /**
     * Deactivate the configuration.
     */
    public function deactivate()
    {
        $this->is_active = false;
        $this->save();
        return $this;
    }

    /**
     * Toggle the configuration status.
     */
    public function toggle()
    {
        $this->is_active = !$this->is_active;
        $this->save();
        return $this;
    }

    /**
     * Check if configuration is active.
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Check if configuration is of a specific type.
     */
    public function isType(string $type): bool
    {
        return $this->type === $type;
    }

    /**
     * Get configuration value with dot notation support.
     */
    public function getConfigDot($key, $default = null)
    {
        return data_get($this->config, $key, $default);
    }

    /**
     * Get parameter value with dot notation support.
     */
    public function getParameterDot($key, $default = null)
    {
        return data_get($this->parameters, $key, $default);
    }

    // ============ STATIC METHODS ============

    /**
     * Get the default configuration for a type.
     */
    public static function getDefaultForType($type)
    {
        return self::active()
            ->byType($type)
            ->first();
    }

    /**
     * Get all configurations grouped by type.
     */
    public static function getGroupedByType()
    {
        return self::active()
            ->get()
            ->groupBy('type');
    }

    /**
     * Create a new configuration with default settings.
     */
    public static function createDefault($name, $type, $config = [], $parameters = [])
    {
        return self::create([
            'name' => $name,
            'slug' => $name,
            'description' => "Default {$type} configuration",
            'config' => $config,
            'type' => $type,
            'is_active' => true,
            'parameters' => $parameters,
        ]);
    }
}
