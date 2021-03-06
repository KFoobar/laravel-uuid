<?php

namespace KFoobar\Uuid\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasUuid
{
    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function (Model $model) {
            $model->addDefaultUuid($model);
        });

        static::saving(function (Model $model) {
            $model->addDefaultUuid($model);
        });
    }

    protected function addDefaultUuid(Model $model)
    {
        if (empty($model->uuid)) {
            $model->uuid = Str::uuid()->toString();
        }
    }
}
