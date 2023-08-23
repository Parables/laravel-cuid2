<?php

namespace Tests\Feature;

use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Support\Facades\Route;
use Tests\Fixtures\CuidRouteBoundPost;
use Tests\Fixtures\CustomCuidRouteBoundPost;
use Tests\Fixtures\MultipleCuidRouteBoundPost;
use Tests\TestCase;

class BindCuidTest extends TestCase
{
    /** @test */
    public function it_binds_to_default_cuid_field()
    {
        $post = factory(CuidRouteBoundPost::class)->create();

        Route::middleware(SubstituteBindings::class)->get('/posts/{post}', function (CuidRouteBoundPost $post) {
            return $post;
        })->name('posts.show');

        $this->get('/posts/' . $post->cuid)->assertSuccessful();
        $this->get(route('posts.show', $post))->assertSuccessful();
    }

    /** @test */
    public function it_fails_on_invalid_default_cuid_field_value()
    {
        $post = factory(CuidRouteBoundPost::class)->create();

        Route::middleware(SubstituteBindings::class)->get('/posts/{post}', function (CuidRouteBoundPost $post) {
            return $post;
        })->name('posts.show');

        $this->get('/posts/' . $post->custom_cuid)->assertNotFound();
        $this->get(route('posts.show', $post->custom_cuid))->assertNotFound();
    }

    /** @test */
    public function it_binds_to_custom_cuid_field()
    {
        $post = factory(CustomCuidRouteBoundPost::class)->create();

        Route::middleware(SubstituteBindings::class)->get('/posts/{post}', function (CustomCuidRouteBoundPost $post) {
            return $post;
        })->name('posts.show');

        $this->get('/posts/' . $post->custom_cuid)->assertSuccessful();
        $this->get(route('posts.show', $post))->assertSuccessful();
    }

    /** @test */
    public function it_fails_on_invalid_custom_cuid_field_value()
    {
        $post = factory(CustomCuidRouteBoundPost::class)->create();

        Route::middleware(SubstituteBindings::class)->get('/posts/{post}', function (CustomCuidRouteBoundPost $post) {
            return $post;
        })->name('posts.show');

        $this->get('/posts/' . $post->cuid)->assertNotFound();
        $this->get(route('posts.show', $post->cuid))->assertNotFound();
    }

    /** @test */
    public function it_binds_to_declared_cuid_column_instead_of_default_when_custom_key_used()
    {
        $post = factory(MultipleCuidRouteBoundPost::class)->create();

        Route::middleware(SubstituteBindings::class)->get('/posts/{post:custom_cuid}', function (MultipleCuidRouteBoundPost $post) {
            return $post;
        })->name('posts.show');

        $this->get('/posts/' . $post->custom_cuid)->assertSuccessful();
        $this->get(route('posts.show', $post))->assertSuccessful();
    }

    /** @test */
    public function it_fails_on_invalid_cuid_when_custom_route_key_used()
    {
        $post = factory(MultipleCuidRouteBoundPost::class)->create();

        Route::middleware(SubstituteBindings::class)->get('/posts/{post:custom_cuid}', function (MultipleCuidRouteBoundPost $post) {
            return $post;
        })->name('posts.show');

        $this->get('/posts/' . $post->cuid)->assertNotFound();
        $this->get(route('posts.show', $post->cuid))->assertNotFound();
    }
}
