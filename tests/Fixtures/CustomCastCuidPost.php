<?php

namespace Tests\Fixtures;

class CustomCastCuidPost extends Model
{
    public function cuidColumn(): string
    {
        return 'custom_cuid';
    }
}
