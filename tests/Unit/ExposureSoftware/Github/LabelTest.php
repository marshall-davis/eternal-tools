<?php
/**
 * Date: 2018-04-01
 * Time: 22:02
 */

namespace Tests\Unit\ExposureSoftware\Github;


use App\Github\Label;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LabelTest extends TestCase
{
    use DatabaseTransactions;

    public function testExists()
    {
        $this->assertTrue(class_exists('App\Github\Label'),
            'Class App\Github\Label did not exist.');
        $this->assertTrue(new Label('Bug') instanceof Label,
            'Label could not be instantiated.');
    }

    public function testFromJson()
    {
        $labelJson = "{
            \"id\": 208045946,
            \"url\": \"https://api.github.com/repos/octocat/Hello-World/labels/bug\",
            \"name\": \"bug\",
            \"description\": \"Houston, we have a problem\",
            \"color\": \"f29513\",
            \"default\": true
        }";

        /** @var Label $label */
        $label = Label::fromJson($labelJson);

        $this->assertTrue($label instanceof Label);
        $this->assertEquals('bug', $label->getName());
        $this->assertEquals('Houston, we have a problem', $label->getDescription());
        $this->assertEquals('f29513', $label->getColor());
        $this->assertTrue($label->isDefault());
        $this->assertEquals(208045946, $label->getId());
    }
}
