<?php

namespace Tests\Unit\User;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class StoreMethodTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */


    public function testCreate()
    {
        Artisan::call('db:seed');

         $data = [
             'name' => 'TestUser',
             'email' => 'testEmail@user.com',
             'role_id' => 1,
             'password' => bcrypt(12345),
         ];

         // Creating new user
         $user = User::create($data);
         $id = $user->id;

         $this->assertTrue(
             $user->name === $data['name'] &&
             $user->email === $data['email'] &&
             $user->role_id === $data['role_id'] &&
             $user->password === $data['password']
         );
    }

    public function testSelect()
    {
        $this->testCreate();
        $user = User::first()->toArray();

        $this->assertContains('Admin', $user);
        $this->assertContains('admin@email.com', $user);
        $this->assertTrue(1 === $user['role_id']);
        $this->assertTrue(1 === $user['status']);

    }

    public function testUpdate()
    {
        $this->testCreate();
        $user = User::first();

        $user->name = 'NewName';
        $user->email = 'newEmail@email.com';
        $user->role_id = 3;
        $user->password = bcrypt('newPassword');
        $user->save($user->toArray());

        $user = $user->toArray();
        $this->assertContains('NewName', $user);
        $this->assertContains('newEmail@email.com', $user);
        $this->assertContains(3 , $user);
    }

    public function testDelete()
    {
        $this->testCreate();

        $user = User::first();
        $id = $user->id;

        $user->delete();
        $this->assertTrue(empty(User::where('id', $id)->first()));
    }
}
