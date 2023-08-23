<?php

namespace Tests\Feature;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Fixtures\Comment;
use Tests\Fixtures\CustomCastCuidPost;
use Tests\Fixtures\CustomCuidPost;
use Tests\Fixtures\MultipleCuidPost;
use Tests\Fixtures\Post;
use Tests\TestCase;
use Visus\Cuid2\Cuid2;

class CuidTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function it_sets_the_cuid_when_creating_a_new_model()
    {
        $post = Post::create(['title' => 'Test post']);

        $this->assertNotNull($post->cuid);
    }

    /** @test */
    public function it_does_not_override_the_cuid_if_it_is_already_set()
    {
        $cuid = 'tac2n4g5qxocjue8x2yqvuqk';

        $post = Post::create(['title' => 'Test post', 'cuid' => $cuid]);

        $this->assertSame($cuid, $post->cuid);
    }

    /** @test */
    public function you_can_find_a_model_by_its_cuid()
    {
        $cuid = 'cpmmr68uurwwc8fr7azqhcx0';

        Post::create(['title' => 'test post', 'cuid' => $cuid]);

        $post = Post::whereCuid($cuid)->first();

        $this->assertInstanceOf(Post::class, $post);
        $this->assertSame($cuid, $post->cuid);
    }

    /** @test */
    public function you_can_find_a_model_by_custom_cuid_parameter()
    {
        $cuid = 'wswei27xilyp2bgww2scvogl';
        $custom_cuid = 'b7vj00gys55fdhxkj14dllsz';

        MultipleCuidPost::create(['title' => 'test post', 'cuid' => $cuid, 'custom_cuid' => $custom_cuid]);

        $post1 = MultipleCuidPost::whereCuid($cuid)->first();
        $this->assertInstanceOf(MultipleCuidPost::class, $post1);
        $this->assertSame($cuid, $post1->cuid);

        $post2 = MultipleCuidPost::whereCuid($cuid, 'cuid')->first();
        $this->assertInstanceOf(MultipleCuidPost::class, $post2);
        $this->assertSame($cuid, $post2->cuid);

        $post3 = MultipleCuidPost::whereCuid($custom_cuid, 'custom_cuid')->first();
        $this->assertInstanceOf(MultipleCuidPost::class, $post3);
        $this->assertSame($custom_cuid, $post3->custom_cuid);
    }

    /** @test */
    public function you_can_search_by_array_of_cuids()
    {
        $first = Post::create(['title' => 'first post', 'cuid' => 'cxtp4coxc8f691g8xz3ue1lg']);
        $second = Post::create(['title' => 'second post', 'cuid' => 'h17zt2lfq3vvczk1z340old7']);

        $this->assertEquals(2, Post::whereCuid([
            'cxtp4coxc8f691g8xz3ue1lg',
            'h17zt2lfq3vvczk1z340old7',
        ])->count());
    }

    /** @test */
    public function you_can_search_by_array_of_cuids_for_custom_column()
    {
        $first = CustomCastCuidPost::create(['title' => 'first post', 'custom_cuid' => 'pomzm3i1sddng8ggqlzv5cln']);
        $second = CustomCastCuidPost::create(['title' => 'second post', 'custom_cuid' => 'blw2xsoaddm700i9ud87ddui']);

        $this->assertEquals(2, CustomCastCuidPost::whereCuid([
            'pomzm3i1sddng8ggqlzv5cln',
            'blw2xsoaddm700i9ud87ddui',
        ], 'custom_cuid')->count());
    }


    /** @test */
    public function you_can_generate_a_cuid_with_casting_and_a_custom_field_name()
    {
        $post = CustomCastCuidPost::create(['title' => 'test post']);

        $this->assertNotNull($post->custom_cuid);
    }

    /** @test */
    public function it_allows_configurable_cuid_column_names()
    {
        $post = CustomCuidPost::create(['title' => 'test-post']);

        $this->assertNotNull($post->custom_cuid);
    }

    /**
     * @test
     * @dataProvider factoriesWithCuidProvider
     */
    public function it_handles_working_with_various_cuid_casts($model, $column)
    {
        tap(factory($model)->create(), function ($post) use ($column) {
            $this->assertNotNull($post->{$column});
        });
    }


    /** @test */
    public function it_handles_a_null_cuid_column()
    {
        tap(Model::withoutEvents(function () {
            return Post::create([
                'title' => 'Nullable cuid',
                'cuid' => null,
            ]);
        }), function ($post) {
            $this->assertNull($post->cuid);
        });
    }

    /** @test */
    public function it_handles_queries_with_multiple_cuid_columns()
    {
        $post = factory(Post::class)->create([
            'cuid' => 'lvzgu2fvdf1i78qwwscvle5g',
        ]);
        $comment = $post->comments()->save(factory(Comment::class)->make([
            'cuid' => 'hjcl2b5qph6b5lyii1i8zts2',
        ]));

        tap($post->comments()->whereCuid($comment->cuid)->first(), function ($comment) {
            $this->assertNotNull($comment);
            $this->assertEquals('lvzgu2fvdf1i78qwwscvle5g', $comment->post->cuid);
        });
    }

    public function factoriesWithCuidProvider(): array
    {
        return [
            'regular cuid' => [Post::class, 'cuid'],
            'custom cuid' => [CustomCuidPost::class, 'custom_cuid'],
        ];
    }
}
