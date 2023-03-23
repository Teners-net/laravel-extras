<?php

namespace Platinum\LaravelExtras\Traits;

use Illuminate\Support\Str;

trait Sluggable
{

  /**
   * Get default source column
   * 
   * @return string
   */
  protected function defaultSourceColumn() 
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
    return static::whereSlug($slug)
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
    return 'slug';
  }
}