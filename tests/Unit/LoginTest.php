<?php
/**
 * Date: 2018-04-10
 * Time: 23:30
 */

namespace Tests\Unit;


use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Mockery;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use DatabaseTransactions;

    public function testLogin()
    {
        $resu = Mockery::mock('App\PasswordUser');
        $resu->shouldReceive('getAuthPassword')->andReturn('testing');
        App::instance('App\PasswordUser', $resu);

        session()->put('redirectTo', '/admin');
        /** @var Response $response */
        $response = $this->post('/login', ['password' => 'testing']);

        $this->assertEquals(Response::HTTP_ACCEPTED, $response->getStatusCode());
        $this->assertEquals('/admin', json_decode($response->getContent())->redirectTo);
    }
}
