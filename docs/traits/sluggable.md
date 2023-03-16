# Sluggable

The Sluggable trait generates unique and SEO friendly slug for model instance when you create or edit the model. It uses the name attribute by default, but can be customized to use any attribute on the model.


## Usage

### Prepare the Model
To use the Sluggable trait, add it to your model:

```php
use Platinum\LaravelExtras\Traits\Sluggable;

class Post extends Model
{
    use Sluggable;
}
```
By default, the trait uses the `name` attribute of the model to generate the slug. You can customize this by setting the `slugSourceColumn` property on the model:
```php
class Post extends Model
{
    use Sluggable;

    protected string $slugSourceColumn = 'title';
}
```
This will use the name attribute of the model to generate the slug.

### Prepare the Migration
Add a slug column to your migratiion:
```php
...
$table->string('name');
$table->string('slug')->unique(); // Here
...
```

### Create or edit
Use any of Laravel's methods to create or edit the model instance without specifying the slug.

Example:
```php
// Create
Post::create([
  'name' => 'Technology in Africa',
]);

// Save
$post = Post::find(1);
$post->update([
  'name' => 'Technologies in Africa',
]);

or

$post->name = 'Technologies in Africa';
$post->save();
```