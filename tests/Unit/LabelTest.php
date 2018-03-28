<?php
/**
 * Date: 2018-03-28
 * Time: 01:06
 */

namespace Tests\Unit;


use App\Models\Label;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LabelTest extends TestCase
{
    use DatabaseTransactions;

    public function testExists()
    {
        $this->assertTrue(class_exists('App\Models\Label'));
    }

    public function testTickets()
    {
        /** @var Label $label */
        $label = factory('App\Models\Label')->create();
        $label->tickets()->saveMany(factory('App\Models\Ticket', 5)->create());

        $this->assertCount(5, $label->tickets);
    }
}
