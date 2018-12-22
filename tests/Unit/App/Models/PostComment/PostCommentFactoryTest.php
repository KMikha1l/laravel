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

    const TYPE_DB = 'DatabaseComment';
    const TYPE_FILE = 'FileComment';

    /**
     * @expectedException App\Exceptions\PostCommentFactoryException
     *
     * @return void
     */
    public function testSpecificFactory()
    {
        $factory = new PostCommentFactory;

        $dB = $factory->specificFactory(self::TYPE_DB);
        $this->assertInstanceOf(DatabaseComment::class, $dB);

        $file = $factory->specificFactory(self::TYPE_FILE);
        $this->assertInstanceOf(FileComment::class, $file);

        $other = $factory->specificFactory('SomeClass');
        $other->assertStatus(500);
    }
}
