<?php

namespace KFoobar\Uuid\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasUuid
{
    /**
     * The database column name to store the UUID.
     *
     * @var string
     */
    protected $uuidColumnName = 'uuid';

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    protected static function bootHasUuid()
    {
        static::creating(function (Model $model) {
            if (empty($model->{$model->getUuidColumnName()})) {
                $model->{$model->getUuidColumnName()} = Str::uuid()->toString();
            }
        });

        static::saving(function (Model $model) {
            if (empty($model->{$model->getUuidColumnName()})) {
                $model->{$model->getUuidColumnName()} = Str::uuid()->toString();
            }
        });
    }

    /**
     * Get the name of the UUID column.
     *
     * @return string
     */
    public function getUuidColumnName()
    {
        return $this->uuidColumnName;
    }
}
