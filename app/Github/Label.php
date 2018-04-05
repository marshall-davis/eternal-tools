<?php
/**
 * Date: 2018-04-01
 * Time: 22:17
 */

namespace App\Github;

use Illuminate\Contracts\Support\Jsonable;


/**
 * Class Label
 *
 * @package App\Github
 */
class Label implements Jsonable
{
    /** @var string $name */
    protected $name;
    /** @var int $id */
    protected $id;
    /** @var string $color */
    protected $color;
    /** @var bool $default */
    protected $default;

    /**
     * @param string|\stdClass $json
     *
     * @return Label
     */
    static function fromJson($json)
    {
        if (is_string($json)) {
            $decoded = json_decode($json);
        } else {
            $decoded = $json;
        }

        /** @var Label $label */
        $label = new self($decoded->name);
        $label->id = $decoded->id;
        $label->color = $decoded->color;
        $label->default = $decoded->default;

        return $label;
    }

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function isDefault()
    {
        return $this->default;
    }

    public function toJson($options = 0)
    {
        return json_encode([
            'id'        => $this->id,
            'name'      => $this->name,
            'color'     => $this->color,
            'isDefault' => $this->default,
        ]);
    }

    public function __toString()
    {
        return $this->toJson();
    }
}
