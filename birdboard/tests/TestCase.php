<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function signIn ($user = null)
    {
        $user = factory($user ?: 'App\User')->create();
        $this->actingAs($user);

        return  $user;
    }
}
