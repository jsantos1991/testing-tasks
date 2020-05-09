<?php

namespace Tests\Unit\Traits;

use App\Tasklist;
use Illuminate\Support\Collection;

trait TasklistControllerTrait
{
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
}
