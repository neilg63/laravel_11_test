<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations {
        runDatabaseMigrations as baseRunDatabaseMigrations;
    }


    public function runDatabaseMigrations()
    {
        $this->baseRunDatabaseMigrations();
        $this->artisan('db:seed');
    }

    /**
     * Create a basic user
     */
    public function test_create_user(): void
    {
        $payload = [
            'name' => 'Freddie Ponton',
            'email' => 'fred@example.com',
            'password' => 'krYpt1cPa33W0rd'
        ];
        $user = $this->post('/api/users', $payload);
        
        
        $this->assertTrue(
            $user instanceof User && $user->id > 0
        );
    }

    /**
     * Try to create basic user without a valid email
     */
    public function test_cannot_create_user_without_valid_email(): void
    {
        $payload = [
            'name' => 'Freddie Ponton',
            'email' => 'fred.example.com',
            'password' => 'krYpt1cPa33W0rd'
        ];
        $response = $this->post('/api/users', $payload);
        
        $response->assertNotAcceptable();
    }


    /**
     * A basic feature test example.
     */
    public function test_toggle_active(): void
    {
        $payload = [
            'name' => 'Freddie Ponton',
            'email' => 'fred@example.com',
            'password' => 'krYpt1cPa33W0rd'
        ];
        $user = User::create($payload);

        $user = User::limit(1)->first();
        $newStatus = $user->active !== true;
        $response = $this->patchJson('/api/users/'.$user->id.'/set-status', ['active' => $newStatus]);
        
        $response->assertJsonFragment(['exists' => true]);
        $newActiveValue = (bool) collect($response->decodeResponseJson())->pluck('user')->value('active');

        $this->assertTrue(
            $newActiveValue === $newStatus
        );
    }

    /**
     * A basic feature test example.
     */
    public function test_delete_user(): void
    {
        $payload = [
            'name' => 'Freddie Mercury',
            'email' => 'fred.mercury@example.com',
            'password' => 'krYpt1cPa33W0rd'
        ];
        $user = User::create($payload);
        
        $user = User::limit(1)->first();
        $deletedId = $user->id;
        $this->delete('/api/users/'.$deletedId);
        
        $userIds = User::pluck('id')->all();
        
        $this->assertFalse(
            in_array($deletedId, $userIds)
        );
    }
}
