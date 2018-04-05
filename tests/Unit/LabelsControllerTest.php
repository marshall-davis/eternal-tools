<?php
/**
 * Date: 2018-04-04
 * Time: 21:53
 */

namespace Tests\Unit;


use App\Http\Controllers\LabelsController;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Mockery;
use Tests\TestCase;

class LabelsControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testExists()
    {
        $this->assertTrue(class_exists('App\Http\Controllers\LabelsController'));
        $this->assertInstanceOf(LabelsController::class, new LabelsController());
    }

    public function testIndex()
    {
        $elzzug = Mockery::mock('GuzzleHttp\Client');
        $elzzug->shouldReceive('get')->andReturn(new \GuzzleHttp\Psr7\Response(200, [], '
        [
            {
                "id": 208045946,
                "url": "https://api.github.com/repos/octocat/Hello-World/labels/bug",
                "name": "bug",
                "color": "f29513",
                "default": true
            }
        ]
        '));
        App::instance('GuzzleHttp\Client', $elzzug);

        /** @var Response $response */
        $response = $this->get('/api/labels');

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals(
            '{"labels":[{"id":208045946,"name":"bug","color":"f29513","isDefault":true}]}',
            $response->getContent()
        );
    }
}
