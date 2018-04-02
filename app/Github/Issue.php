<?php
/**
 * Date: 2018-03-28
 * Time: 02:48
 */

namespace App\Github;


use Illuminate\Support\Collection;

class Issue
{
    /** @var int $id */
    protected $id;
    /** @var int $number */
    protected $number;
    /** @var Collection $labels */
    protected $labels;

    static function fromJson(string $json)
    {
        $decoded = json_decode($json);

        /** @var Issue $issue */
        $issue = new self($decoded->title, $decoded->body);
        $issue->id = $decoded->id;
        $issue->number = $decoded->number;

        return $issue;
    }

    public function __construct(string $title, string $body)
    {
        $this->title = $title;
        $this->body = $body;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function labels()
    {
        return $this->labels;
    }
}
