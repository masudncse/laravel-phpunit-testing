<?php

namespace Tests;

use App\Models\User;

trait Authentication
{
    private $user;

    public function checkAuthentication()
    {
        $this->user = User::factory()->create();

        $this->post(route('login'), [
            'email' => $this->user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
    }
}
