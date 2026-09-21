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
     * Boot the UUID trait for a model.
     *
     * @return void
     */
    protected static function bootHasUuid()
    {
        static::saving(function (Model $model): void {
            $column = $model->getUuidColumnName();

            if ($model->exists && ! array_key_exists($column, $model->getAttributes())) {
                return;
            }

            if (empty($model->getAttribute($column))) {
                $model->setAttribute($column, Str::uuid()->toString());
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
