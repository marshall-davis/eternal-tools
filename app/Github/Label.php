<?php
/**
 * Date: 2018-04-01
 * Time: 22:17
 */

namespace App\Github;


/**
 * Class Label
 *
 * @package App\Github
 */
class Label
{
    /** @var string $name */
    protected $name;
    /** @var string $description */
    protected $description;
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

    public function getDescription()
    {
        return $this->description;
    }
}
