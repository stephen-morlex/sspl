<?php

namespace Tests\Feature\Livewire;

use Tests\TestCase;
use App\Livewire\HomePage;
use Livewire\Livewire;

class HomePageTest extends TestCase
{
    /** @test */
    public function it_can_render_the_home_page_component()
    {
        Livewire::test(HomePage::class)
            ->assertStatus(200);
    }
    
    /** @test */
    public function it_displays_welcome_message()
    {
        Livewire::test(HomePage::class)
            ->assertSee('Football League Dashboard');
    }
}