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
                'skills'        => BackstorySkill::select('text')->get(),
                'adjectives'    => BackstoryAdjective::select('text')->get(),
                'nationalities' => BackstoryNationality::select('text')->get(),
                'traits'        => BackstoryTrait::select('text')->get(),
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

    public function testCreate()
    {
        $response = $this->post('/api/backstories/skill/', [
            'text' => 'a test skill',
        ]);

        $this->assertTrue($response->getStatusCode() === Response::HTTP_OK);
        $content = json_decode($response->getContent());
        $this->assertNotNull($content);
        $this->assertEquals('a test skill', $content->text);
        $this->assertTrue(is_int($content->id));
    }

    public function testCreateBadPortion()
    {
        $response = $this->post('/api/backstories/nothing/', [
            'text' => 'a test skill',
        ]);

        $this->assertTrue($response->getStatusCode() === Response::HTTP_BAD_REQUEST, 'Incorrect response code returned.');
        $content = json_decode($response->getContent());
        $this->assertNotNull($content, 'Content could not be parsed as JSON.');
        $this->assertTrue(is_string($content->error));
    }

    public function testUpdate()
    {
        /** @var BackstorySkill $skill */
        $skill = factory('App\Models\BackstorySkill')->create();

        $response = $this->put("/api/backstories/skill/{$skill->id}", [
            'text' => 'a test skill',
        ])->assertSuccessful();

        $content = json_decode($response->getContent());

        $this->assertNotNull($content, 'Content could not be parsed as JSON.');
        $this->assertEquals($skill->id, $content->id, 'Wrong ID returned.');
        $this->assertEquals('a test skill', $skill->fresh()->text, 'Text was not updated.');
    }

    public function testUpdateNonexistent()
    {
        $skill_id = BackstorySkill::max('id') + 1;

        $response = $this->put("/api/backstories/skill/{$skill_id }", [
            'text' => 'a test skill',
        ]);

        $this->assertTrue($response->getStatusCode() === Response::HTTP_NOT_FOUND, "Incorrect status code of {$response->getStatusCode()}.");
        $content = json_decode($response->getContent());
        $this->assertNotNull($content, 'Content could not be parsed as JSON.');
        $this->assertTrue(is_string($content->error));
    }

    public function testUpdateBadPortion()
    {
        /** @var BackstorySkill $skill */
        $skill = factory('App\Models\BackstorySkill')->create();

        $response = $this->put("/api/backstories/test/{$skill->id}", [
            'text' => 'a test skill',
        ]);

        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
        $this->assertNull(json_decode($response->getContent()), 'Content could not be parsed as JSON.');
    }

    public function testDelete()
    {
        /** @var BackstorySkill $skill */
        $skill = factory('App\Models\BackstorySkill')->create();

        $response = $this->delete("/api/backstories/skill/{$skill->id}")->assertSuccessful();

        $this->assertEquals($skill->id, json_decode($response->getContent())->id);
    }

    public function testDeleteNotFound()
    {
        $skill_id = BackstorySkill::max('id') + 1;

        $response = $this->delete("/api/backstories/skill/{$skill_id}");

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        $this->assertEquals($skill_id, json_decode($response->getContent())->id);
    }
}
