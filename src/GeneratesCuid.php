<?php

namespace Parables\Cuid;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Builder;
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
trait GeneratesCuid
{
    /**
     * The name of the column that should be used for the Cuid.
     *
     * @return string
     */
    public function cuidColumn(): string
    {
        return 'cuid';
    }

    /**
     * The names of the columns that should be used for the Cuid.
     *
     * @return array
     */
    public function cuidColumns(): array
    {
        return [$this->cuidColumn()];
    }

    /**
     * Scope queries to find by Cuid.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string|array                          $cuid
     * @param  string                                $cuidColumn
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereCuid($query, $cuid, $cuidColumn = null): Builder
    {
        $cuidColumn = !is_null($cuidColumn) &&
            in_array($cuidColumn, $this->cuidColumns())
            ? $cuidColumn
            : $this->cuidColumns()[0];

        return $query->whereIn(
            $this->qualifyColumn($cuidColumn),
            Arr::wrap($cuid)
        );
    }

    public static function bootGeneratesCuid(): void
    {
        static::creating(
            function ($model) {
                foreach ($model->cuidColumns() as $columnName => $size) {
                    if (!isset($model->attributes[$columnName])) {
                        $model->{$columnName} = new Cuid2(maxLength: ($size < 4 || $size > 32) ? null : $size);
                    }
                }
            }
        );
    }
}
