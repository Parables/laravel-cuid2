<?php

namespace Tests\Fixtures;

use Parables\Cuid\BindsOnCuid;
use Parables\Cuid\GeneratesCuid;

class MultipleCuidRouteBoundPost extends Model
{
    use GeneratesCuid;
    use BindsOnCuid;

    public function cuidColumns(): array
    {
        return [
            'cuid', 'custom_cuid',
        ];
    }
}
