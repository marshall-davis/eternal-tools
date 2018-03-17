<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AppTest extends TestCase
{
    use DatabaseTransactions;

    public function testDatabase()
    {
        /** @var \PDO $connection */
        $connection = DB::connection()->getPdo();

        $this->assertStringStartsWith('Connection OK', $connection->getAttribute(\PDO::ATTR_CONNECTION_STATUS));
    }
}
