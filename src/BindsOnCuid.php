<?php

namespace Parables\Cuid;

use Illuminate\Database\Eloquent\Model;

/**
 * Cuid route binding trait.
 *
 * Alters getRouteKeyName() to the return cuidColumn()
 *
 * @author    Parables Boltnoel <parables@github.com>
 * @copyright 2017 Parables Boltnoel
 * @license   MIT <https://github.com/parables>
 */
trait BindsOnCuid
{
    abstract public static function cuidColumn(): string;

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return self::cuidColumn();
    }

    /**
     * Route bind desired cuid field
     * Default 'cuid' column name has been set.
     *
     * @param  string  $value
     * @param  null|string  $field
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function resolveRouteBinding($value, $field = null): Model
    {
        return self::whereCuid($value, $field)->firstOrFail();
    }
}
