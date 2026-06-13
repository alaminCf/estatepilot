<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class WebsiteSetting extends Model
{
    protected $fillable = [
        'setting_key',
        'setting_value',
        'setting_group',
    ];

    /**
     * Get a setting value by key
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        $setting = Cache::remember("setting_{$key}", 3600, function () use ($key) {
            return self::where('setting_key', $key)->first();
        });

        return $setting ? $setting->setting_value : $default;
    }

    /**
     * Set a setting value
     *
     * @param string $key
     * @param mixed $value
     * @param string $group
     * @return WebsiteSetting
     */
    public static function set(string $key, $value, string $group = 'general'): WebsiteSetting
    {
        $setting = self::updateOrCreate(
            ['setting_key' => $key],
            ['setting_value' => $value, 'setting_group' => $group]
        );

        Cache::forget("setting_{$key}");
        Cache::forget("settings_group_{$group}");

        return $setting;
    }

    /**
     * Get all settings for a group
     *
     * @param string $group
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getGroup(string $group)
    {
        return Cache::remember("settings_group_{$group}", 3600, function () use ($group) {
            return self::where('setting_group', $group)->pluck('setting_value', 'setting_key');
        });
    }

    /**
     * Set multiple settings at once
     *
     * @param array $settings
     * @param string $group
     * @return void
     */
    public static function setMany(array $settings, string $group = 'general'): void
    {
        foreach ($settings as $key => $value) {
            self::set($key, $value, $group);
        }
    }

    /**
     * Clear all settings cache
     *
     * @return void
     */
    public static function clearCache(): void
    {
        $settings = self::all();
        foreach ($settings as $setting) {
            Cache::forget("setting_{$setting->setting_key}");
            Cache::forget("settings_group_{$setting->setting_group}");
        }
    }
}
