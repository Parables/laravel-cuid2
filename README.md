# Laravel Model UUIDs

## Introduction

> Note: This package uses [Cuid2]() as the initial version is deprecated.

<!-- TODO: Link to the deprecation notice -->

## Why Cuid2?

> **Note**: this package explicitly does not disable auto-incrementing on your Eloquent models. In terms of database indexing, it is generally more efficient to use auto-incrementing integers for your internal querying. Indexing your `cuid` column will make lookups against that column fast, without impacting queries between related models.

## Installation

This package is installed via [Composer](https://getcomposer.org/). To install, run the following command.

```bash
composer require parables/cuid
```

## Code Samples

In order to use this package, you simply need to import and use the trait within your Eloquent models.

```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Parables\Cuid\GeneratesCuid;

class Post extends Model
{
    use GeneratesCuid;
}
```

It is assumed that you already have a field named `cuid` in your database, which is used to store the generated value. If you wish to use a custom column name, for example if you want your primary `id` column to be a `Cuid`, you can define a `cuidColumn` method in your model.

```php
class Post extends Model
{
    public function cuidColumn(): string
    {
        return 'id';
    }
}
```

## Use Cuid as primary key

If you choose to use a Cuid as your primary model key (`id`), then use `GeneratesCuidAsPrimaryKey` trait on your model.

```php
<?php

namespace App;

use Parables\Cuid\GeneratesCuidAsPrimaryKey;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use GeneratesCuidAsPrimaryKey;
}
```

And update your migrations

```diff
 Schema::create('users', function (Blueprint $table) {
-     $table->id();
+     $table->string('id')->primary();
 });
```

This trait also provides a query scope which will allow you to easily find your records based on their Cuid, and respects any custom field name you choose.

```php
// Find a specific post using the `cuidColumn()`
$post = Post::whereCuid($cuid)->first();

// Find multiple posts using the `cuidColumn()`
$post = Post::whereCuid([$first, $second])->get();

// Find a specific post with a custom column name
$post = Post::whereCuid($cuid, 'custom_column')->first();

// Find multiple posts with a custom column name
$post = Post::whereCuid([$first, $second], 'custom_column')->get();
```

## Route model binding

Should you wish to leverage implicit route model binding on your `cuid` field, you may use the `BindsOnCuid` trait, which will use the value returned by `cuidColumn()`. Should you require additional control over the binding, you may override the `getRouteKeyName` method directly.

```php
public function getRouteKeyName(): string
{
    return 'cuid';
}
```

You can generate multiple Cuid columns for a model by returning an array of column names in the `cuidColumns()` method.

If you use the `cuidColumns()` method, then **first** element in the array must be the value returned by the `cuidColumn()` method which by default is `cuid`. If you overwrite the `cuidColumn()` method, put its return value as the **first** element in the `cuidColumns()` return array.

When querying using the `whereCuid()` scope, the default column - specified by `cuidColumn()` will be used.

```php
class Post extends Model
{
    public function cuidColumns(): array
    {
        return [$this->cuidColumn(), 'custom_column'];
    }
}
```

The `cuidColumns` must return an array. You can customize the generated `Cuid` for each column. Specify the name of the column as the key and optionally specify the size as an integer value greater than 4 but less than 32(`(($size > 4) && $(size < 32))`).

```php
  public function cuidColumns(): array
    {
        // Option 1: array of column names: this will use the default size: `24`
        return ['cuid', 'custom_column'];

        // Option 2: array where the key is the column name and the value is the size
        return ['cuid' => 6, 'custom_column' => 10];

    }
```

## Support

If you are having general issues with this package, feel free to contact me on [Twitter](https://twitter.com/pboltnoel).

If you believe you have found an issue, please report it using the [GitHub issue tracker](https://github.com/Parables/laravel-model-cuid/issues), or better yet, fork the repository and submit a pull request.

If you're using this package, I'd love to hear your thoughts. Thanks!

## Treeware

You're free to use this package, but if it makes it to your production environment you are required to buy the world a tree.

It’s now common knowledge that one of the best tools to tackle the climate crisis and keep our temperatures from rising above 1.5C is to plant trees. If you support this package and contribute to the Treeware forest you’ll be creating employment for local families and restoring wildlife habitats.

You can buy trees [here](https://plant.treeware.earth/michaeldyrynda/laravel-model-cuid)

Read more about Treeware at [treeware.earth](https://treeware.earth)

## Credits

-   [visus-io](https://github.com/visus-io) for cuid2
-   Michael Dyrynda [michaeldyrynda](https://github.com/michaeldyrynda) for [laravel-model-uuid](https://github.com/michaeldyrynda/laravel-model-uuid).
