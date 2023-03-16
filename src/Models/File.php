<?php

namespace Platinum\LaravelExtras\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Platinum\LaravelExtras\Helpers\ReadableValue;

class File extends Model
{
  use HasFactory ;

  /**
   * Get the file size in human readable
   */
  public function getRealSizeAttribute(): ?string
  {
    if ($this->path) {
      return ReadableValue::realSize($this->size);
    }
  }

  /**
   * Get the file's url
   */
  public function getUrlAttribute(): ?string
  {
    if ($this->path) {
      return Storage::url($this->path);
    }
  }

  /**
   * Accessors to append to the model instance
   */
  public $append = [
    'real_size', 'url'
  ];
}