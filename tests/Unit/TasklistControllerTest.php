<?php

namespace Tests\Unit;

use App\Http\Controllers\TasklistController;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;
use App\Tasklist;
use Mockery as m;

class TasklistControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @test
     */
    public function index_when_empty_collection()
    {

        $mock = m::mock(Tasklist::class)
            ->shouldReceive([
                'all' => new Collection()
            ])
            ->getMock();


        $controller = new TasklistController($mock);
        $tasklists = $controller->index();
        $this->assertInstanceOf(Collection::class, $tasklists);
        $this->assertTrue($tasklists->isEmpty());
    }

    
    /**
     * A basic unit test example.
     *
     * @test
     */
    public function index_when_not_empty_collection()
    {
    
        $collection = new Collection();
        $tasklist = new Tasklist();
        $collection->push($tasklist);

        $mock = m::mock(Tasklist::class)
            ->shouldReceive([
                'all' => $collection
            ])
            ->getMock();

        $controller = new TasklistController($mock);
        $tasklists = $controller->index();
        $this->assertInstanceOf(Collection::class, $tasklists);
        $this->assertTrue($tasklists->count() > 0);
        $this->assertInstanceOf(Tasklist::class, $tasklists->first());
    }
}
