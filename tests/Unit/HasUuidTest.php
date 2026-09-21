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

    /**
     * The pattern of a version 4 UUID.
     *
     * @var string
     */
    protected string $regex = '/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i';

    /**
     * Create the tables for the test models.
     *
     * @return void
     */
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

    /**
     * Test that the model is an Eloquent model.
     *
     * @return void
     */
    public function testModelIsModel(): void
    {
        $post = new Post;

        $this->assertInstanceOf(Model::class, $post);
    }

    /**
     * Test that a UUID is generated when a model is created.
     *
     * @return void
     */
    public function testCreateModel(): void
    {
        $post = Post::create(['heading' => 'Lorem ipsum dolor']);

        $this->assertMatchesRegularExpression($this->regex, $post->uuid);

        $post = Post::first();

        $this->assertMatchesRegularExpression($this->regex, $post->uuid);
    }

    /**
     * Test that the UUID is kept when a model is updated.
     *
     * @return void
     */
    public function testUpdateModel(): void
    {
        $post = Post::create(['heading' => 'Lorem ipsum dolor']);

        $firstUuid = $post->uuid;

        $post->update([
            'heading' => 'Dolor ipsum lorem',
        ]);

        $secondUuid = $post->uuid;

        $this->assertEquals($firstUuid, $secondUuid);
    }

    /**
     * Test that a new UUID is generated when the UUID is emptied.
     *
     * @return void
     */
    public function testSaveModelWithEmptyUuid(): void
    {
        $post = Post::create(['heading' => 'Lorem ipsum dolor']);

        $post->uuid = '';
        $post->save();

        $post = Post::first();

        $this->assertNotEmpty($post->uuid);
        $this->assertNotNull($post->uuid);
        $this->assertMatchesRegularExpression($this->regex, $post->uuid);
    }

    /**
     * Test that the UUID is kept when a partially loaded model is updated.
     *
     * @return void
     */
    public function testUpdatePartiallyLoadedModelKeepsUuid(): void
    {
        $uuid = Post::create(['heading' => 'Lorem ipsum dolor'])->uuid;

        Post::select(['id', 'heading'])->first()->update(['heading' => 'Dolor ipsum lorem']);

        $this->assertSame($uuid, Post::first()->uuid);
    }
}
