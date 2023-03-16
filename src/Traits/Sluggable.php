<?php

namespace Platinum\LaravelExtras\Traits;

use Illuminate\Support\Str;

trait Sluggable
{

  /**
   * Get default source column
   */
  protected function defaultSourceColumn(): string 
  {
    return config('laravel-extras.source-column', '');
  }

  /**
   * Boot the sluggable trait for the model.
   */
  public static function bootSluggable()
  {
    static::creating(function ($model) {
      $model->slug = $model->generateSlug();
    });

    static::saving(function ($model) {
      if ($model->isDirty($model->getSourceColumn())) {
        $model->slug = $model->generateSlug();
      }
    });
  }

  /**
   * Get the slug source column
   */
  protected function getSourceColumn(): string
  {
    return $this->slugSourceColumn ?? $this->defaultSourceColumn();
  }

  /**
   * Generate a unique slug for the model.
   */
  protected function generateSlug(): string
  {
    $slug = Str::slug($this->getSourceColumn());

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
   */
  protected function slugExists(string $slug, int $id = 0): bool
  {
    return static::whereSlug($slug)
      ->where('id', '<>', $id)
      ->exists();
  }

  /**
   * Get the route key for the model.
   */
  public function getRouteKeyName(): string
  {
    return 'slug';
  }
}