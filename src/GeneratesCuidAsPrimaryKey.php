<?php

namespace Parables\Cuid;


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
trait GeneratesCuidAsPrimaryKey
{
    use GeneratesCuid;
    use CuidAsPrimaryKey;
    use BindsOnCuid;

    /**
     * The name of the column that should be used for the Cuid.
     *
     * @return string
     */
    public function cuidColumn(): string
    {
        return 'id';
    }
}
