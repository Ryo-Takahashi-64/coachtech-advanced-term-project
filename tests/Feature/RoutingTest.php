<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoutingTest extends TestCase
{
    use RefreshDatabase;

    public function test_no_auth()
    {
        $response = $this->get('/');
        $response->assertRedirect('/login');

        $response = $this->get('/');
        $response = $this->get('/attendance/start');
        $response->assertRedirect('/login');

        $response = $this->get('/');
        $response = $this->get('/attendance/end');
        $response->assertRedirect('/login');

        $response = $this->get('/');
        $response = $this->get('/break/start');
        $response->assertRedirect('/login');

        $response = $this->get('/');
        $response = $this->get('/break/end');
        $response->assertRedirect('/login');

        $response = $this->get('/attendance');
        $response->assertRedirect('/login');

        $response = $this->get('/attendance/user');
        $response->assertRedirect('/login');

        $response = $this->get('/logout');
        $response->assertRedirect('/login');
    }

    public function test_no_route()
    {
        $response = $this->get('/aaaa');
        $response->assertStatus(404);
    }

    public function test_auth()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user);

        $response = $this->get('/');
        $response->assertStatus(200);

        $response = $this->get('/');
        $response = $this->get('/attendance/start');
        $response->assertRedirect('/');

        $response = $this->get('/');
        $response = $this->get('/attendance/end');
        $response->assertRedirect('/');

        $response = $this->get('/');
        $response = $this->get('/break/start');
        $response->assertRedirect('/');

        $response = $this->get('/');
        $response = $this->get('/break/end');
        $response->assertRedirect('/');

        $response = $this->get('/attendance');
        $response->assertStatus(200);

        $response = $this->get('/attendance/user');
        $response->assertStatus(200);

        $response = $this->get('/logout');
        $response->assertRedirect('/');
    }

}
