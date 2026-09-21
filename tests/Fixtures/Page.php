<?php

namespace KFoobar\Uuid\Test\Fixtures;

use Illuminate\Database\Eloquent\Model;
use KFoobar\Uuid\Traits\HasUuid;

class Page extends Model
{
    use HasUuid;

    /**
     * The name of the UUID column.
     *
     * @var string
     */
    const UUID = 'public_id';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
}
