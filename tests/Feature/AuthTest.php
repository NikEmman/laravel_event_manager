<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase; // This resets the DB after every test!

    // Register tests

    public function test_a_user_can_view_the_register_page()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('Register');
    }


    public function test_a_user_can_register_successfully()
    {
        $response = $this->post('/register', [
            'name' => 'TestUser',
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $this->assertCount(1, User::all());
        $response->assertRedirect('/');
        $this->assertAuthenticated();
    }

    public function test_a_user_cannot_register_with_a_duplicate_username()
    {
        User::create([
            'name' => 'dickyv',
            'email' => 'original@example.com',
            'password' => bcrypt('password123')
        ]);

        $response = $this->from('/register')->post('/register', [
            'name' => 'dickyv',
            'email' => 'new-email@example.com',
            'password' => 'password123',
        ]);


        $response->assertRedirect('/register');
        $response->assertSessionHasErrors(['name']);
        $this->assertCount(1, User::all()); // Still only 1 user in DB
    }


    public function test_a_user_cannot_register_with_a_duplicate_email()
    {

        User::create([
            'name' => 'original_user',
            'email' => 'dickyv@example.com',
            'password' => bcrypt('password123')
        ]);


        $response = $this->from('/register')->post('/register', [
            'name' => 'new_user',
            'email' => 'dickyv@example.com',
            'password' => 'password123',
        ]);


        $response->assertRedirect('/register');
        $response->assertSessionHasErrors(['email']);
    }
    public function test_registration_requires_name_email_and_password()
    {
        $response = $this->post('/register', []);

        $response->assertSessionHasErrors(['name', 'email', 'password']);
    }


    public function test_registration_name_must_be_at_least_3_characters()
    {
        $response = $this->post('/register', [
            'name' => 'ab',
            'email' => 'test@test.com',
            'password' => 'password123'
        ]);

        $response->assertSessionHasErrors(['name']);
    }


    public function test_registration_email_must_be_a_valid_email_format()
    {
        $response = $this->post('/register', [
            'name' => 'DickyV',
            'email' => 'not-an-email',
            'password' => 'password123'
        ]);

        $response->assertSessionHasErrors(['email']);
    }


    public function test_registration_password_must_be_at_least_8_characters()
    {
        $response = $this->post('/register', [
            'name' => 'DickyV',
            'email' => 'test@test.com',
            'password' => '1234567'
        ]);

        $response->assertSessionHasErrors(['password']);
    }
    // login tests 
    public function test_a_user_can_view_the_login_page()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Welcome Back');

        $response->assertSee('Log In');
    }
    public function test_login_requires_email_and_password()
    {
        $response = $this->post('/login', []);

        $response->assertSessionHasErrors(['email', 'password']);
    }
    public function test_a_user_can_login_successfully()
    {
        // Create a user in the database
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        // Attempt to login
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);


        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }
    public function test_a_user_cannot_login_with_incorrect_password()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHas('failure');
        $this->assertGuest();
    }
    public function test_a_user_can_logout()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_login_is_rate_limited_after_five_attempts()
    {
        // Attempt to login 5 times with wrong credentials
        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', [
                'email' => 'test@example.com',
                'password' => 'wrong-password'
            ]);
        }

        // The 6th attempt should hit the throttle
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrong-password'
        ]);

        $response->assertStatus(429); // 429 for Too Many Requests
    }


}