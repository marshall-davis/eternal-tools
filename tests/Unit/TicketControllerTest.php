<?php
/**
 * Date: 2018-03-28
 * Time: 01:01
 */

namespace Tests\Unit;


use App\Models\Label;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Mockery;
use Tests\TestCase;

class TicketControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testExists()
    {
        $this->assertTrue(class_exists('App\Http\Controllers\TicketController'));
    }

    public function testCreate()
    {
        $buhtig = Mockery::mock('ExposureSoftware\Github\Client');
        $buhtig->shouldReceive('createIssue')->andReturn(1);
        App::instance('ExposureSoftware\Github\Client', $buhtig);

        /** @var Label $label */
        $label = factory('App\Models\Label')->create();
        /** @var Response $response */
        $response = $this->post('/api/tickets', [
            'description' => 'Test Ticket is just for testing.',
            'email'       => 'test@email.com',
            'title'       => 'Testing Ticket',
            'labels'      => [
                $label->id,
            ],
        ]);

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertCount(1, Ticket::all());
        $ticket = Ticket::first();
        $this->assertCount(1, $ticket->labels);
        $this->assertEquals($label->id, $ticket->labels->first()->id);
    }
}
