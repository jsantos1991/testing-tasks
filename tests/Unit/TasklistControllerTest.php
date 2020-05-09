<?php

namespace Tests\Unit;

use App\Http\Controllers\TasklistController;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;
use App\Tasklist;
use Mockery as m;

class TasklistControllerTest extends TestCase
{
    /** @test */
    public function index_when_empty_collection()
    {
        $mock = m::mock(Tasklist::class)
            ->shouldReceive(
                [
                    'all' => new Collection()
                ]
            )
            ->getMock();


        $controller = new TasklistController($mock);
        $tasklists = $controller->index();
        $this->assertInstanceOf(Collection::class, $tasklists);
        $this->assertTrue($tasklists->isEmpty());
    }

    /** @test */
    public function index_when_not_empty_collection()
    {
        $collection = new Collection();
        $tasklist = new Tasklist();
        $collection->push($tasklist);

        $mock = m::mock(Tasklist::class)
            ->shouldReceive(
                [
                    'all' => $collection
                ]
            )
            ->getMock();

        $controller = new TasklistController($mock);
        /** @var Collection $tasklists */
        $tasklists = $controller->index();
        $this->assertInstanceOf(Collection::class, $tasklists);
        $this->assertTrue($tasklists->count() > 0);
        $this->assertInstanceOf(Tasklist::class, $tasklists->first());
    }

    /**
     * @test
     * @dataProvider indexDataProvider
     * @param Collection $all
     * @param bool $isEmpty
     */
    public function index(Collection $all, bool $isEmpty)
    {
        $mock = m::mock(Tasklist::class)
            ->shouldReceive(
                [
                    'all' => $all
                ]
            )
            ->getMock();

        $controller = new TasklistController($mock);
        /** @var Collection $tasklists */
        $tasklists = $controller->index();

        $this->assertInstanceOf(Collection::class, $tasklists);
        $this->assertEquals($isEmpty, $tasklists->isEmpty());
    }

    public function indexDataProvider()
    {
        return [
            'When all returns an empty collection' => [
                'all' => new Collection(),
                'isEmpty' => true
            ],
            'When all returns a collection with data' => [
                'all' => (new Collection())->push(new Tasklist()),
                'isEmpty' => false
            ],
        ];
    }

    protected function tearDown(): void
    {
        // this will close mocks before each test.
        m::close();
    }
}
