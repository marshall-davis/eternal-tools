<?php
/**
 * Date: 2018-03-19
 * Time: 23:07
 */

namespace Tests\Unit;


use App\Models\Map;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MapTest
{
    use DatabaseTransactions;

    public function testExists()
    {
        $this->assertInstanceOf(Map::class, new Map());

        /** @var Map $adjective */
        $adjective = factory('App\Models\Map')->create();

        $this->assertCount(1, Map::all());
        $this->assertTrue(is_string($adjective->text));
    }
}
