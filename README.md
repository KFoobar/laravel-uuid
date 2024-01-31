# Laravel UUID Trait for Eloquent Models

Enhance your Laravel models with UUID functionality seamlessly using our trait, compatible with Laravel 5.5 and newer versions.

## Installation Guide

Install the package through Composer with the following command:

```bash
composer require kfoobar/laravel-uuid
```

## How to Use

To integrate UUIDs into your models, simply use the `KFoobar\Uuid\Traits\HasUuid` trait in your model class like so:

```php
use Illuminate\Database\Eloquent\Model;
use KFoobar\Uuid\Traits\HasUuid;

class Post extends Model
{
    use HasUuid;
}
```

This will automatically generate a UUID for each new model instance.

## Contributing

We encourage contributions from the community! Whether it's improving the code, fixing bugs, or enhancing documentation, your input is valuable.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
