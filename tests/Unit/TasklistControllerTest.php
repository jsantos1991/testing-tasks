<?php

namespace Tests\Unit;

use App\Http\Controllers\TasklistController;
use Illuminate\Support\Collection;
use Tests\TestCase;
use App\Tasklist;

class TasklistControllerTest extends TestCase
{
    
    private $controller;

    public function setUp(): void
    {
        $this->controller = new TasklistController;
    }
    
    /**
     * A basic unit test example.
     *
     * @test
     */
    public function example()
    {
        $this->mock(Tasklist::class, function ($mock) {
            $mock->shouldReceive('all')->once();
        });

        $tasklists = $this->controller->index();
        $this->assertInstanceOf(Collection::class, $tasklists);
    }
}
