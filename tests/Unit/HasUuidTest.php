<?php

namespace KFoobar\Uuid\Test\Unit;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use KFoobar\Uuid\Test\Fixtures\Post;
use KFoobar\Uuid\Test\Unit\TestCase;

class HasUuidTest extends TestCase
{
    use RefreshDatabase;

    protected $regex = '/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i';

    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('posts', function (Blueprint $table) {
            $table->id('id');
            $table->uuid('uuid');
            $table->string('heading')->nullable();
            $table->timestamps();
        });
    }

    public function testModelIsModel(): void
    {
        $post = new Post;

        $this->assertInstanceOf(Model::class, $post);
    }

    public function testCreateModel()
    {
        $post = Post::create(['heading' => 'Lorem ipsum dolor']);

        $this->assertMatchesRegularExpression($this->regex, $post->uuid);

        $post = Post::first();

        $this->assertMatchesRegularExpression($this->regex, $post->uuid);
    }

    public function testUpdateModel()
    {
        $post = Post::create(['heading' => 'Lorem ipsum dolor']);

        $firstUuid = $post->uuid;

        $post->update([
            'heading' => 'Dolor ipsum lorem',
        ]);

        $secondUuid = $post->uuid;

        $this->assertEquals($firstUuid, $secondUuid);
    }

    public function testSaveModelWithEmptyUuid()
    {
        $post = Post::create(['heading' => 'Lorem ipsum dolor']);

        $post->uuid = '';
        $post->save();

        $post = Post::first();

        $this->assertNotEmpty($post->uuid);
        $this->assertNotNull($post->uuid);
        $this->assertMatchesRegularExpression($this->regex, $post->uuid);
    }
}
