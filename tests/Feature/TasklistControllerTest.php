<?php

namespace Tests\Feature;

use App\Tasklist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TasklistControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_should_return_an_empty_collection_if_there_are_no_tasklist()
    {
        $response = $this->get('/api/v1/tasklists');

        $response->assertOk();
        $this->assertEmpty(json_decode($response->getContent()));
    }

    public function test_index_should_return_a_collection_of_tasklists_if_success()
    {
        // Given we have a tasklist in the database.
        $tasklist = new Tasklist();
        $tasklist->name = 'Test Tasklist';
        $tasklist->save();

        // When we try to get the existing tasklists.
        $response = $this->get('/api/v1/tasklists');

        $data = json_decode($response->getContent());

        // Then a collection of tasklists should be returned.
        // And it should contain the created tasklist.
        $response->assertOk();
        $this->assertNotEmpty($data);
        $response->assertJsonFragment(['name' => $tasklist->name]);
    }
}
