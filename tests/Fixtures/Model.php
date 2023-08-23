<?php

namespace Tests\Fixtures;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Parables\Cuid\GeneratesCuid;

abstract class Model extends BaseModel
{
    use GeneratesCuid;

    /**
     * {@inheritdoc}
     */
    protected $table = 'posts';

    /**
     * {@inheritdoc}
     */
    protected $guarded = [];

    /**
     * {@inheritdoc}
     */
    public $timestamps = false;
}
