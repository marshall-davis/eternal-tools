<?php
/**
 * Date: 2018-03-28
 * Time: 01:15
 */

namespace Tests\Unit;


use App\Models\Label;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TicketTest extends TestCase
{
    use DatabaseTransactions;

    public function testExists()
    {
        $this->assertTrue(class_exists('App\Models\Ticket'));
    }

    public function testLabels()
    {
        /** @var Ticket $ticket */
        $ticket = factory('App\Models\Ticket')->create();
        /** @var Label $label */
        $label = factory('App\Models\Label')->create();
        $ticket->labels()->save($label);

        $this->assertCount(1, $ticket->labels);
        $this->assertEquals($label->id, $ticket->labels->first()->id);
    }
}
