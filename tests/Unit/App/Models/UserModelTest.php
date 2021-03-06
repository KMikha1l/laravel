<?php

namespace Tests\Unit\App\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class UserModelTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */

    public function testCreate()
    {
//        Artisan::call('db:seed');

         $data = [
             'name' => 'TestUser',
             'email' => 'testEmail@user.com',
             'role_id' => 1,
             'password' => bcrypt(12345),
         ];

        // Creating new user
        $user = User::create($data);

        $this->assertEquals($user->name, $data['name']);
        $this->assertEquals($user->email, $data['email']);
        $this->assertEquals($user->role_id, $data['role_id']);

    }

    public function testSelect()
    {
        $this->initialData();
        $user = User::where('id', 1)->first();

        $this->assertEquals('Admin', $user->name);
        $this->assertEquals('admin@email.com', $user->email);
        $this->assertEquals(1, $user->status);
        $this->assertEquals(1, $user->role_id);
    }

    public function testUpdate()
    {
        $this->initialData();
        $user = User::first();

        $user->name = 'NewName';
        $user->email = 'newEmail@email.com';
        $user->role_id = 3;
        $user->password = bcrypt('newPassword');
        $user->save($user->toArray());

        $this->assertEquals($user->name, 'NewName');
        $this->assertEquals($user->email, 'newEmail@email.com');
        $this->assertEquals($user->role_id, 3);
    }

    public function testDelete()
    {
        $newUser = $this->initialData();
        $id = $newUser->id;
        $newUser->delete();

        $this->assertTrue(empty(User::where('id', $id)->first()));
    }

    /**
     * Creating begin data for update,
     * select and delete methods
     * @return mixed
     */
    public function initialData()
    {
        $data = [
            'name' => 'TestUser',
            'email' => 'testEmail' . rand(100, 999) . '@user.com',
            'role_id' => 1,
            'password' => bcrypt(12345),
        ];

        // Creating new user
        return User::create($data);
    }
}
