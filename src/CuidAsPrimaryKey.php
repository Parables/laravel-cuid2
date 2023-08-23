<?php

namespace Parables\Cuid;

use Visus\Cuid2\Cuid2;

/**
 * Cuid generation trait.
 *
 * Note: This generates a Cuid2 as the previous version is deprecated
 *
 * Include this trait in any Eloquent model where you wish to automatically set
 * a Cuid field. When saving, if the `cuid` field has not been set, generate a
 * new Cuid value, which will be set on the model and saved by Eloquent.
 *
 * @author    Parables Boltnoel <parables@github.com>
 * @copyright 2017 Parables Boltnoel
 * @license   MIT <https://github.com/parables>
 *
 * @method static \Illuminate\Database\Eloquent\Builder  whereCuid(string $cuid)
 */
trait CuidAsPrimaryKey
{
    /**
     * Boot the trait, adding a creating observer.
     *
     * Create a new Cuid if the model's attribute has not been set as the primary key.
     *
     * This trait explicitly disables auto-incrementing on your Eloquent models
     *
     * @return void
     */
    public static function bootCuidAsPrimaryKey(): void
    {
        static::creating(
            function ($model) {
                $cuid = new Cuid2();
                $primaryKeyColumn = $model->cuidColumn();
                $model->$primaryKeyColumn = $cuid;
                $model->keyType = 'string';
                $model->incrementing = false;
                $model->{$model->getKeyName()} = $model->{$model->getKeyName()} ?: (string) $cuid;
            }
        );
    }


    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}
