<?php

namespace Tests\Fixtures;

use Parables\Cuid\BindsOnCuid;
use Parables\Cuid\GeneratesCuid;

class CuidRouteBoundPost extends Model
{
    use GeneratesCuid;
    use BindsOnCuid;

    public function cuidColumn(): string
    {
        return 'cuid';
    }
}
