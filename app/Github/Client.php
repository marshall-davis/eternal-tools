<?php
/**
 * Date: 2018-03-28
 * Time: 02:17
 */

namespace App\Github;


use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Collection;

/**
 * Class GithubClient
 *
 * @package App
 */
class Client
{
    const API_ROOT = 'https://api.github.com';

    /** @var Client $guzzle */
    protected $guzzle;
    /** @var Collection $headers */
    protected $headers;

    /**
     * Client constructor.
     *
     * @param GuzzleClient $guzzle
     */
    public function __construct(GuzzleClient $guzzle)
    {
        $this->guzzle = $guzzle;
        $this->headers = collect([
            'Authorization: token' => config('github.oauth_token'),
        ]);
    }

    /**
     * @param string          $title
     * @param string          $body
     * @param Collection|null $labels
     *
     * @return Issue
     */
    public function createIssue(string $title, string $body, Collection $labels = null)
    {
        /** @var Issue $issue */
        $issue = Issue::fromJson($this->guzzle->post(
            "{$this->repoUri()}/issues",
            [
                'json' => [
                    'title'  => $title,
                    'body'   => $body,
                    'labels' => $labels->toArray(),
                ],
            ]
        )->getBody());

        return $issue;
    }

    /**
     * @return Collection
     */
    public function getLabels()
    {
        /** @var Collection $labels */
        $labels = collect();
        $response = json_decode($this->guzzle->get("{$this->repoUri()}/labels")->getBody());

        foreach ($response as $labelJson) {
            $labels->push(Label::fromJson($labelJson));
        }

        return $labels;
    }

    /**
     * Returns the URL for the configuration repository.
     *
     * @return string
     */
    protected function repoUri()
    {
        return implode('/', [
            self::API_ROOT,
            'repos',
            config('github.owner'),
            config('github.repository'),
        ]);
    }
}
