<?php
/**
 * Date: 2018-04-01
 * Time: 22:02
 */

namespace Tests\Unit\ExposureSoftware\Github;


use App\Github\Client;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use DatabaseTransactions;

    public function testExists()
    {
        $this->assertTrue(class_exists('App\Github\Client'));
        $this->assertTrue(App::make('App\Github\Client') instanceof Client);
    }
}
