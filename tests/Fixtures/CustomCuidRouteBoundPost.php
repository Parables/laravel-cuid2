<?php

namespace Tests\Fixtures;

use Parables\Cuid\BindsOnCuid;
use Parables\Cuid\GeneratesCuid;

class CustomCuidRouteBoundPost extends Model
{
    use GeneratesCuid;
    use BindsOnCuid;

    public function cuidColumn(): string
    {
        return 'custom_cuid';
    }
}
