<?php

namespace Teners\LaravelExtras\Traits;

use Illuminate\Support\Str;

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
            $model[$model->getSlugColumn()] = $model->generateSlug();
        });

        static::saving(function ($model) {
            if ($model->isDirty($model->getSourceColumn())) {
                $model[$model->getSlugColumn()] = $model->generateSlug();
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
        $sourceColumn = $this->getSourceColumn();

        $slug = Str::slug($this->$sourceColumn);

        $count = 0;
        $originalSlug = $slug;

        while ($this->slugExists($slug, $this->id)) {
            $count++;
            $slug = $originalSlug . '-' . $count;
        }

        return $slug;
    }

    /**
     * Determine if the given slug already exists.
     *
     * @param string $slug
     * @param int $id
     *
     * @return bool
     */
    protected function slugExists(string $slug, $id = 0)
    {
        return static::where($this->getSlugColumn(), $slug)
            ->where('id', '<>', $id)
            ->exists();
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
