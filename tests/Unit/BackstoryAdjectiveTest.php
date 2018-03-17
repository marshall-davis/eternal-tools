<?php
/**
 * Date: 2018-03-17
 * Time: 00:33
 */

namespace Tests\Unit;


use App\Models\BackstoryAdjective;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BackstoryAdjectiveTest extends TestCase
{
    use DatabaseTransactions;

    public function testExists()
    {
        $this->assertInstanceOf(BackstoryAdjective::class, new BackstoryAdjective());

        /** @var BackstoryAdjective $adjective */
        $adjective = factory('App\Models\BackstoryAdjective')->create();

        $this->assertCount(1, BackstoryAdjective::all());
        $this->assertTrue(is_string($adjective->text));
    }
}
