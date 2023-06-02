<?php

namespace Platinum\LaravelExtras\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Platinum\LaravelExtras\Helpers\ReadableValue;

class File extends Model
{

  /**
   * The attributes that are not mass assignable.
   *
   * @var array<int, string>
   */
  protected $guarded = ['id'];
  
  /**
   * Get the file size in human readable
   */
  public function getRealSizeAttribute(): ?string
  {
    if ($this->path) {
      return ReadableValue::realSize($this->size);
    }
        
    return '';
  }

  /**
   * Get the file's url
   */
  public function getUrlAttribute(): ?string
  {
    if ($this->path) {
      return Storage::url($this->path);
    }
    
    return '';
  }

  /**
   * Accessors to append to the model instance
   */
  public $appends = [
    'real_size', 'url'
  ];
}
