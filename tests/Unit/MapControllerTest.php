<?php
/**
 * Date: 2018-03-19
 * Time: 23:21
 */

namespace Tests\Unit;


use App\Http\Controllers\MapsController;
use App\Models\Map;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class MapControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testExistence()
    {
        $this->assertInstanceOf('App\Http\Controllers\MapsController', new MapsController());
    }

    public function testCreate()
    {
        /** @var Response $response */
        $response = $this->post('/api/maps', [
            'steps' => "[{\"position\":{\"x\":479,\"y\":279},\"size\":8,\"color\":\"#008000\"},{\"position\":{\"x\":615,\"y\":283},\"size\":8,\"color\":\"#008000\"},{\"position\":{\"x\":644,\"y\":250},\"size\":8,\"color\":\"#008000\"},{\"position\":{\"x\":475,\"y\":263},\"size\":8,\"color\":\"#008000\"}]",
        ]);

        $this->assertTrue($response->getStatusCode() === Response::HTTP_OK, 'Response status was not OK.');
        $this->assertCount(1, Map::all());
        /** @var Map $map */
        $map = Map::first();
        $this->assertEquals($map->slug, json_decode($response->getContent())->id);
    }

    public function testGet()
    {
        /** @var Map $map */
        $map = factory('App\Models\Map')->create();
        $response = $this->get("/api/maps/{$map->slug}");

        $this->assertEquals($response->getStatusCode(), Response::HTTP_OK);
        $response_data = json_decode($response->getContent());
        $this->assertEquals($map->id, $response_data->id);
        $this->assertEquals($map->author, $response_data->author);
        $this->assertEquals($map->steps, $response_data->steps);
    }

    public function testPut()
    {
        $steps = "[{\"position\":{\"x\":5,\"y\":5},\"size\":8,\"color\":\"#008000\"},{\"position\":{\"x\":20,\"y\":20},\"size\":8,\"color\":\"#008000\"}]";
        /** @var Map $map */
        $map = factory('App\Models\Map')->create();
        $response = $this->put("/api/maps/{$map->slug}", [
            'steps' => $steps
        ]);

        $this->assertEquals($response->getStatusCode(), Response::HTTP_OK);
        $this->assertEquals($steps, $map->fresh()->steps);
    }

    public function testPutNonexistent()
    {
        $steps = "[{\"position\":{\"x\":5,\"y\":5},\"size\":8,\"color\":\"#008000\"},{\"position\":{\"x\":20,\"y\":20},\"size\":8,\"color\":\"#008000\"}]";
        $response = $this->put("/api/maps/-1", [
            'steps' => $steps
        ]);

        $this->assertEquals($response->getStatusCode(), Response::HTTP_NOT_FOUND);
    }
}
