<?php
/**
 * Date: 2018-03-17
 * Time: 00:33
 */

namespace Tests\Unit;


use App\Models\BackstoryNationality;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BackstoryNationalityTest extends TestCase
{
    use DatabaseTransactions;

    public function testExists()
    {
        $this->assertInstanceOf(BackstoryNationality::class, new BackstoryNationality());

        /** @var BackstoryNationality $adjective */
        $adjective = factory('App\Models\BackstoryNationality')->create();

        $this->assertCount(1, BackstoryNationality::all());
        $this->assertTrue(is_string($adjective->text));
    }
}
