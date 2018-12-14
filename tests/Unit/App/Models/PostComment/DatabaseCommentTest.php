<?php

namespace Tests\Unit\App\Models\PostComment;

use App\Models\PostComment\DatabaseComment;
use App\Models\PostComment\PostComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DatabaseCommentTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $comments = $this->initialData();
        $comments->index();

        $comments = json_decode($comments->index());
        $this->assertCount(2, $comments);
        $this->assertEquals($comments[0]->id, 1);
        $this->assertEquals($comments[0]->user_id, 1);
        $this->assertEquals($comments[0]->post_id, 1);
        $this->assertEquals($comments[0]->text, 'comment #1');
        $this->assertEquals($comments[0]->created_at, '2018-12-07 15:13:25');
        $this->assertEquals($comments[0]->updated_at, '2018-12-07 15:13:25');
    }

    public function testPostComments()
    {
        $comments = $this->initialData();

        $this->assertCount(2, json_decode($comments->postComments(1)));
        $this->assertEquals($comments->postComments(2), '{"data":"Comment not found"}');
        $this->assertEquals($comments->postComments(3), '{"data":"Comment not found"}');
    }

    public function testShow()
    {
        $comments = $this->initialData();

        $comment = $comments->show(1);

        $this->assertEquals(json_decode($comment)->id, 1);
        $this->assertEquals(json_decode($comment)->user_id, 1);
        $this->assertEquals(json_decode($comment)->post_id, 1);
        $this->assertEquals(json_decode($comment)->text, 'comment #1');
        $this->assertEquals(json_decode($comment)->created_at, '2018-12-07 15:13:25');
        $this->assertEquals(json_decode($comment)->updated_at, '2018-12-07 15:13:25');
    }

    public function testStore()
    {
        $comments = $this->initialData();

        $request = new Request;
        $request->post_id = 1;
        $request->user_id = 1;
        $request->text = 'Just comment text';

        $result = $comments->store($request);
        $this->assertEquals(json_decode($result)->post_id, 1);
        $this->assertEquals(json_decode($result)->user_id, 1);
        $this->assertEquals(json_decode($result)->text, 'Just comment text');
    }

    public function testUpdate()
    {
        $comments = $this->initialData();

        $request = new Request;
        $request->merge(['post_id' => 1]);
        $request->merge(['user_id' => 1]);
        $request->merge(['text' => 'Just comment text']);

        $comments->update($request, 1);
        $updatedComment = PostComment::where('id', 1)->first();

        $this->assertEquals($updatedComment->post_id, 1);
        $this->assertEquals($updatedComment->user_id, 1);
        $this->assertEquals($updatedComment->text, 'Just comment text');
    }

    public function testDestroy()
    {
        $comments = $this->initialData();

        $comments->destroy(1);

        $deletedComment = PostComment::where('id', 1)->first();
        $this->assertNull($deletedComment);
    }

    public function initialData()
    {
        Artisan::call('config:cache');
        Artisan::call('db:seed');

        return $comments = new DatabaseComment;
    }
}
