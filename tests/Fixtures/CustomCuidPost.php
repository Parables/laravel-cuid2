<?php

namespace Tests\Fixtures;

class CustomCuidPost extends Model
{
    public function cuidColumn(): string
    {
        return 'custom_cuid';
    }
}
