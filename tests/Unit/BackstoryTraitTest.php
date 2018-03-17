<?php
/**
 * Date: 2018-03-17
 * Time: 00:33
 */

namespace Tests\Unit;


use App\Models\BackstoryTrait;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BackstoryTraitTest extends TestCase
{
    use DatabaseTransactions;

    public function testExists()
    {
        $this->assertInstanceOf(BackstoryTrait::class, new BackstoryTrait());

        /** @var BackstoryTrait $adjective */
        $adjective = factory('App\Models\BackstoryTrait')->create();

        $this->assertCount(1, BackstoryTrait::all());
        $this->assertTrue(is_string($adjective->text));
    }
}
