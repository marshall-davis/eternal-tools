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
        $eussi = Mockery::mock('App\Github\Issue');
        $eussi->shouldReceive('getNumber')->andReturn(13);

        $buhtig = Mockery::mock('App\Github\Client');
        $buhtig->shouldReceive('createIssue')->andReturn($eussi);
        App::instance('App\Github\Client', $buhtig);

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
        $responseJson = json_decode($response->getContent());
        $this->assertEquals(Ticket::max('id'), $responseJson->ticket);
        $this->assertTrue($responseJson->subscribed);
        $this->assertCount(1, Ticket::all());
        $ticket = Ticket::first();
        $this->assertCount(1, $ticket->labels, 'Correct labels were not applied.');
        $this->assertEquals($label->id, $ticket->labels->first()->id);
    }
}
