<?php

namespace Tests\Unit\App\Models\PostComment;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\PostComments\PostCommentFactory;

use App\Models\PostComments\DatabaseComment;
use App\Models\PostComments\FileComment;

class PostCommentFactoryTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSpecificFactory()
    {
        $factory = new PostCommentFactory;

        $dB = $factory->specificFactory('DatabaseComment');
        $this->assertInstanceOf(DatabaseComment::class, $dB);

        $file = $factory->specificFactory('FileComment');
        $this->assertInstanceOf(FileComment::class, $file);

        $other = $factory->specificFactory('SomeClass');
        $this->assertNull($other);
    }
}
