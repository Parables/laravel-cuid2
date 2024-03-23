<?php

namespace Parables\Cuid;


/**
 * Cuid generation trait.
 *
 * Note: This generates a Cuid2 as the previous version is deprecated
 *
 * Include this trait in any Eloquent model where you wish to automatically set
 * a Cuid field. When saving, if the `cuidColumn()` field has not been set,
 * this trait will generate a new Cuid value which will be set as the
 * primary key on the model and saved by Eloquent.
 *
 * @author    Parables Boltnoel <parables@github.com>
 * @copyright 2017 Parables Boltnoel
 * @license   MIT <https://github.com/parables>
 *
 * @method static \Illuminate\Database\Eloquent\Builder  whereCuid(string $cuid)
 */
trait CuidAsPrimaryKey
{
    use GeneratesCuid;
    use BindsOnCuid;

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    protected $incrementing = false;

     /**
     * The data type of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The name of the column that should be used for the Cuid.
     *
     * @return string
     */
    public static function cuidColumn(): string
    {
        return 'id';
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
