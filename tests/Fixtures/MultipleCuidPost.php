<?php

namespace Tests\Fixtures;

class MultipleCuidPost extends Model
{
    public function cuidColumns(): array
    {
        return ['cuid', 'custom_cuid'];
    }
}
