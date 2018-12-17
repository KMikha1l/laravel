<?php

namespace Tests\Unit\App\Models\PostComment;

use App\Models\PostComment\FileComment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Tests\TestCase;
use Carbon\Carbon;

class FileCommentTest extends TestCase
{
    use RefreshDatabase;
    private static $data;


    // All comments
    public function testIndex()
    {
        $comments = $this->initialData();
        $this->assertEquals(json_decode($comments->index()), json_decode(self::$data));
    }

    // Comments for current post_id
    public function postComments()
    {
        $comments = $this->initialData();
        $this->assertCount(3, json_decode($comments->postComments(1)));
    }

    // Comment by id
    public function testShow()
    {
        $comments = $this->initialData();
        $obj = 1;

        $comment = json_decode($comments->show(1))->{$obj};

        $this->assertEquals(1, $comment->id);
        $this->assertEquals(2, $comment->user_id);
        $this->assertEquals(1, $comment->post_id);
        $this->assertEquals('My first comment', $comment->text);
    }

    // Saving new comment
    public function testStore()
    {
        $comments = $this->initialData();
        $request = new Request;
        $request->merge([
            'id' => 4,
            'user_id' => 5,
            'text' => 'Just new comment',
            'created_at' => $currentTime = Carbon::now(),
            'updated_at' => $currentTime
        ]);

        $newComment = $comments->store($request);
        $this->assertEquals(json_decode($newComment)->user_id, $request->user_id);
        $this->assertEquals(json_decode($newComment)->post_id, $request->post_id);
        $this->assertEquals(json_decode($newComment)->text, $request->text);
    }

    // Updating current comment
    public function update()
    {
        $comments = $this->initialData();
        $request = new Request;
        $request->merge([
            'user_id' => 5,
            'post_id' => 6,
            'text' => 'updated text',
        ]);

        $comments->update($request, 1);
        $originalComment = $this->getFileData()->where('id', 1)->toArray();

        $this->assertEquals($request->all(), $originalComment);
    }

    // Deleting current comment
    public function destroy()
    {
        $comments = $this->initialData();
        $comments->destroy(1);
        $deletedComment = $this->getFileData();

        $this->assertNull($deletedComment);
    }

    public function initialData()
    {
        // Initializing of tests comments data
        self::$data = '
        {
            "1": {
                "id": 1,
                "user_id": 2,
                "post_id": 1,
                "text": "My first comment",
                "created_at": {
                    "date": "2018-11-15 11:00:40.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "updated_at": {
                    "date": "2018-11-15 11:00:40.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                }
            },
            "2": {
                "id": 2,
                "user_id": 2,
                "post_id": 1,
                "text": "My first comment",
                "created_at": {
                    "date": "2018-11-15 11:00:40.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "updated_at": {
                    "date": "2018-11-15 11:00:40.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                }
            },
            "3": {
                "id": 3,
                "user_id": 1,
                "post_id": 2,
                "text": "My first comment",
                "created_at": {
                    "date": "2018-11-15 11:00:40.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "updated_at": {
                    "date": "2018-11-15 11:00:40.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                }
            }
        }    
    ';

        // Replacing work file via test file
        FileComment::$storagePath = 'testComments.json';

        // Saving a new data into test comments file
        Storage::disk('comments')->put(FileComment::$storagePath, self::$data);
        
        return new FileComment;
    }

    public function getFileData()
    {
        $fileContent = Storage::disk('comments')->get(FileComment::$storagePath);
        $jsonComments = json_decode($fileContent);
        return collect($jsonComments);
    }
}
