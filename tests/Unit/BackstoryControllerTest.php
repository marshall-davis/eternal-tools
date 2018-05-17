<?php
/**
 * Date: 2018-03-17
 * Time: 00:57
 */

namespace Tests\Unit;


use App\Http\Controllers\BackstoryController;
use App\Models\BackstoryAdjective;
use App\Models\BackstoryNationality;
use App\Models\BackstoryNeighborhood;
use App\Models\BackstorySkill;
use App\Models\BackstoryTrait;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class BackstoryControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testExists()
    {
        $this->assertInstanceOf('App\Http\Controllers\BackstoryController', new BackstoryController());
    }

    public function testIndex()
    {
        /** @var Response $response */
        $response = $this->get('/api/backstories');

        $this->assertTrue($response->getStatusCode() === Response::HTTP_OK);
        $this->assertJson(
            json_encode([
                'skills' => BackstorySkill::select('text')->get(),
                'adjectives' => BackstoryAdjective::select('text')->get(),
                'nationalities' => BackstoryNationality::select('text')->get(),
                'traits' => BackstoryTrait::select('text')->get(),
            ])
        );
    }

    public function testPortion()
    {
        /** @var Response $response */
        $response = $this->get('/api/backstories/trait');

        $this->assertTrue($response->getStatusCode() === Response::HTTP_OK);
        $this->assertJson(
            json_encode([
                'options' => BackstoryTrait::select('text')->get(),
            ])
        );
    }

    public function testNonPortion()
    {
        /** @var Response $response */
        $response = $this->get('/api/backstories/nothing');

        $this->assertTrue($response->getStatusCode() === Response::HTTP_NO_CONTENT);
    }
}
