<?php

namespace Teners\LaravelExtras\Traits;

use Illuminate\Support\Str;
use InvalidArgumentException;

trait Sluggable
{
    /**
     * Get default slug column
     *
     * @return string
     */
    protected function defaultSlugColumn()
    {
        return config('laravel-extras.slug_column', 'slug');
    }

    /**
     * Get default source column
     *
     * @return string
     */
    protected function defaultSourceColumn()
    {
        return config('laravel-extras.source_column');
    }

    /**
     * Boot the sluggable trait for the model.
     */
    public static function bootSluggable()
    {
        static::creating(function ($model) {
            if (empty($model->{$model->getSlugColumn()})) {
                $model->{$model->getSlugColumn()} = $model->generateSlug();
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty($model->getSourceColumn())) {
                $model->{$model->getSlugColumn()} = $model->generateSlug();
            }
        });
    }

    /**
     * Get the slug source column
     *
     * @return string
     */
    protected function getSlugColumn()
    {
        return $this->slugColumn ?? $this->defaultSlugColumn();
    }

    /**
     * Get the slug source column
     *
     * @return string
     */
    protected function getSourceColumn()
    {
        return $this->slugSourceColumn ?? $this->defaultSourceColumn();
    }

    /**
     * Generate a unique slug for the
     *
     * @return string model.
     */
    protected function generateSlug()
    {
        $sourceValue = $this->{$this->getSourceColumn()};

        if (empty($sourceValue)) {
            throw new InvalidArgumentException('Slug source column value cannot be empty');
        }

        $baseSlug = Str::slug($sourceValue);

        $existingCount = static::where($this->getSlugColumn(), 'LIKE', $baseSlug . '%')
            ->where('id', '!=', $this->id ?? 0)
            ->count();

        return $existingCount > 0 ? $baseSlug . '-' . ($existingCount + 1) : $baseSlug;
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        $use_slug = $this->useSlugAsRouteKey ?? config('laravel-extras.slug_as_route', true);
        return $use_slug ? $this->getSlugColumn() : 'id';
    }
}
