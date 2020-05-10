<?php

namespace Tests\Unit;

use App\Http\Controllers\TasklistController;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;
use App\Tasklist;
use Mockery as m;
use Tests\Unit\Traits\TasklistControllerTrait;
use App\Repositories\TasklistRepository;

class TasklistControllerTest extends TestCase
{
    use TasklistControllerTrait;

    public function test_index_when_empty_collection()
    {
        $mock = m::mock(TasklistRepository::class)
            ->shouldReceive(
                [
                    'all' => new Collection()
                ]
            )
            ->getMock();


        $controller = new TasklistController($mock);
        $tasklists = $controller->all();
        $this->assertInstanceOf(Collection::class, $tasklists);
        $this->assertTrue($tasklists->isEmpty());
    }

    public function test_index_when_not_empty_collection()
    {
        $collection = new Collection();
        $tasklist = new Tasklist();
        $collection->push($tasklist);

        $mock = m::mock(TasklistRepository::class)
            ->shouldReceive(
                [
                    'all' => $collection
                ]
            )
            ->getMock();

        $controller = new TasklistController($mock);
        /** @var Collection $tasklists */
        $tasklists = $controller->all();
        $this->assertInstanceOf(Collection::class, $tasklists);
        $this->assertTrue($tasklists->count() > 0);
        $this->assertInstanceOf(Tasklist::class, $tasklists->first());
    }

    /**
     * @dataProvider indexDataProvider
     * @param  Collection  $all
     * @param  bool  $isEmpty
     */
    public function test_index(Collection $all, bool $isEmpty)
    {
        $mock = m::mock(TasklistRepository::class)
            ->shouldReceive(
                [
                    'all' => $all
                ]
            )
            ->getMock();

        $controller = new TasklistController($mock);
        /** @var Collection $tasklists */
        $tasklists = $controller->all();

        $this->assertInstanceOf(Collection::class, $tasklists);
        $this->assertEquals($isEmpty, $tasklists->isEmpty());
    }

    public function test_on_store_it_should_return_false_when_given_property_is_not_valid()
    {
        $requestMock = m::mock(Request::class)
            ->shouldReceive(
                [
                    'get' => 123
                ]
            )
            ->getMock();

        $tasklistMock = m::mock(TasklistRepository::class)
            ->shouldReceive(
                [
                    'save' => false
                ]
            )
            ->getMock();

        $controller = new TasklistController($tasklistMock);
        $wasSaved = $controller->create($requestMock);

        $this->assertFalse($wasSaved);
    }

    public function test_on_store_it_should_return_true_if_success()
    {
        $requestMock = m::mock(Request::class)
            ->shouldReceive(
                [
                    'get' => 123
                ]
            )
            ->getMock();

        $tasklistMock = m::mock(TasklistRepository::class)
            ->shouldReceive(
                [
                    'save' => true
                ]
            )
            ->getMock();

        $controller = new TasklistController($tasklistMock);
        $wasSaved = $controller->create($requestMock);

        $this->assertTrue($wasSaved);
    }

    public function test_on_show_it_should_return_false_when_given_id_that_does_not_exist()
    {
        $tasklist = m::mock(TasklistRepository::class)
            ->shouldReceive(
                [
                    'find' => false
                ]
            )->getMock();

        $controller = new TasklistController($tasklist);
        $result = $controller->show(0);

        $this->assertFalse($result);
    }

    public function test_on_show_it_should_return_a_tasklist_on_success()
    {
        $tasklist = m::mock(TasklistRepository::class)
            ->shouldReceive(
                [
                    'find' => new Tasklist()
                ]
            )->getMock();

        $controller = new TasklistController($tasklist);
        $result = $controller->show(1);

        $this->assertInstanceOf(Tasklist::class, $result);
    }

    public function test_on_update_it_should_fail_when_given_id_does_not_exist()
    {
        $tasklist = m::mock(TasklistRepository::class)
            ->shouldReceive(
                [
                    'find' => false
                ]
            )->getMock();

        $controller = new TasklistController($tasklist);
        $response = $controller->update(new Request(), 0);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals(false, $response->getContent());
    }

    public function test_on_update_it_should_return_false_if_update_fails()
    {
        $tasklist = m::mock(TasklistRepository::class)
            ->shouldReceive(
                [
                    'find' => new Tasklist(),
                    'save' => false
                ]
            )->getMock();

        $request = m::mock(Request::class)
            ->shouldReceive(
                [
                    'get' => 123 // Name is a string so passing a number would fail.
                ]
            )->getMock();

        $controller = new TasklistController($tasklist);
        $response = $controller->update($request, 1);

        $this->assertFalse($response);
    }

    public function test_on_update_it_should_return_true_if_update_succeeds()
    {
        $tasklist = m::mock(TasklistRepository::class)
            ->shouldReceive(
                [
                    'find' => new Tasklist(),
                    'save' => true
                ]
            )->getMock();

        $request = m::mock(Request::class)
            ->shouldReceive(
                [
                    'get' => 'Test Name'
                ]
            )->getMock();

        $controller = new TasklistController($tasklist);
        $response = $controller->update($request, 1);

        $this->assertTrue($response);
    }

    public function test_on_destroy_it_should_fail_when_given_id_does_not_exist()
    {
        $tasklist = m::mock(TasklistRepository::class)
            ->shouldReceive(
                [
                    'find' => null
                ]
            )->getMock();

        $controller = new TasklistController($tasklist);
        $response = $controller->delete(0);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals(false, $response->getContent());
    }

    public function test_on_destroy_it_should_return_false_when_delete_fails()
    {
        $tasklistRepository = m::mock(TasklistRepository::class)
            ->shouldReceive(
                [
                    'find' => new Tasklist(),
                    'delete' => false
                ]
            )->getMock();

        $controller = new TasklistController($tasklistRepository);
        $response = $controller->delete(1);

        $this->assertFalse($response);
    }

    public function test_on_destroy_it_should_return_true_if_delete_succeeds()
    {
        $tasklistRepository = m::mock(TasklistRepository::class)
            ->shouldReceive(
                [
                    'find' => new Tasklist(),
                    'delete' => true
                ]
            )->getMock();

        $controller = new TasklistController($tasklistRepository);
        $response = $controller->delete(1);

        $this->assertTrue($response);
    }

    public function test_it_should_return_nothing_when_there_are_no_tasks_for_the_given_tasklist()
    {
        $tasklist = m::mock(Tasklist::class)
            ->shouldReceive(['getAttribute' => null])
            ->getMock();

        $controller = new TasklistController(new TasklistRepository(new Tasklist()));
        $response = $controller->tasks($tasklist);

        $this->assertEmpty($response);
    }

    public function test_it_should_return_all_tasks_of_the_given_tasklist()
    {
        $tasklist = m::mock(Tasklist::class)
            ->shouldReceive(['getAttribute' => (new Collection())->push(new Task())])
            ->getMock();

        $controller = new TasklistController(new TasklistRepository(new Tasklist()));
        $response = $controller->tasks($tasklist);

        $this->assertNotEmpty($response);
        $this->assertInstanceOf(Task::class, $response->first());
    }

    protected function tearDown(): void
    {
        // this will close mocks after each test.
        m::close();
    }
}
