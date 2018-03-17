<?php
/**
 * Date: 2018-03-17
 * Time: 00:33
 */

namespace Tests\Unit;


use App\Models\BackstorySkill;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BackstorySkillTest extends TestCase
{
    use DatabaseTransactions;

    public function testExists()
    {
        $this->assertInstanceOf(BackstorySkill::class, new BackstorySkill());

        /** @var BackstorySkill $adjective */
        $adjective = factory('App\Models\BackstorySkill')->create();

        $this->assertCount(1, BackstorySkill::all());
        $this->assertTrue(is_string($adjective->text));
    }
}
