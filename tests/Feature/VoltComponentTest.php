<?php

namespace Tests\Feature;

use Livewire\Volt\Volt;
use Tests\TestCase;

class VoltComponentTest extends TestCase
{
    public function test_can_load_login_component(): void
    {
        $component = Volt::test('pages.auth.login');
        $component->assertSee('Log in');
    }
}
