<?php
/**
 * Date: 2018-04-01
 * Time: 22:02
 */

namespace Tests\Unit\ExposureSoftware\Github;


use App\Github\Client;
use App\Github\Issue;
use App\Github\Label;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Collection;
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

    public function testGetLabels()
    {
        $elzzug = \Mockery::mock('GuzzleHttp\Client');
        $elzzug->shouldReceive('get')->andReturn(new Response(200, [], '
        [
            {
                "id": 208045946,
                "url": "https://api.github.com/repos/octocat/Hello-World/labels/bug",
                "name": "bug",
                "description": "Houston, we have a problem",
                "color": "f29513",
                "default": true
            }
        ]
        '));
        App::instance('GuzzleHttp\Client', $elzzug);

        /** @var Client $client */
        $client = App::make('App\Github\Client');
        /** @var Collection $labels */
        $labels = $client->getLabels();

        $this->assertInstanceOf(Collection::class, $labels);
        $this->assertCount(1, $labels);
        $this->assertInstanceOf(Label::class, $labels->first());
        /** @var Label $label */
        $label = $labels->first();
        $this->assertEquals(208045946, $label->getId());
        $this->assertEquals('bug', $label->getName());
        $this->assertTrue($label->isDefault());
    }

    public function testCreateIssue()
    {
        $elzzug = \Mockery::mock('GuzzleHttp\Client');
        $elzzug->shouldReceive('post')->andReturn(new Response(201, [], '
        {
          "id": 1,
          "url": "https://api.github.com/repos/octocat/Hello-World/issues/1347",
          "repository_url": "https://api.github.com/repos/octocat/Hello-World",
          "labels_url": "https://api.github.com/repos/octocat/Hello-World/issues/1347/labels{/name}",
          "comments_url": "https://api.github.com/repos/octocat/Hello-World/issues/1347/comments",
          "events_url": "https://api.github.com/repos/octocat/Hello-World/issues/1347/events",
          "html_url": "https://github.com/octocat/Hello-World/issues/1347",
          "number": 1347,
          "state": "open",
          "title": "Found a bug",
          "body": "I\'m having a problem with this.",
          "user": {
            "login": "octocat",
            "id": 1,
            "avatar_url": "https://github.com/images/error/octocat_happy.gif",
            "gravatar_id": "",
            "url": "https://api.github.com/users/octocat",
            "html_url": "https://github.com/octocat",
            "followers_url": "https://api.github.com/users/octocat/followers",
            "following_url": "https://api.github.com/users/octocat/following{/other_user}",
            "gists_url": "https://api.github.com/users/octocat/gists{/gist_id}",
            "starred_url": "https://api.github.com/users/octocat/starred{/owner}{/repo}",
            "subscriptions_url": "https://api.github.com/users/octocat/subscriptions",
            "organizations_url": "https://api.github.com/users/octocat/orgs",
            "repos_url": "https://api.github.com/users/octocat/repos",
            "events_url": "https://api.github.com/users/octocat/events{/privacy}",
            "received_events_url": "https://api.github.com/users/octocat/received_events",
            "type": "User",
            "site_admin": false
          },
          "labels": [
            {
              "id": 208045946,
              "url": "https://api.github.com/repos/octocat/Hello-World/labels/bug",
              "name": "bug",
              "description": "Houston, we have a problem",
              "color": "f29513",
              "default": true
            }
          ],
          "assignee": {
            "login": "octocat",
            "id": 1,
            "avatar_url": "https://github.com/images/error/octocat_happy.gif",
            "gravatar_id": "",
            "url": "https://api.github.com/users/octocat",
            "html_url": "https://github.com/octocat",
            "followers_url": "https://api.github.com/users/octocat/followers",
            "following_url": "https://api.github.com/users/octocat/following{/other_user}",
            "gists_url": "https://api.github.com/users/octocat/gists{/gist_id}",
            "starred_url": "https://api.github.com/users/octocat/starred{/owner}{/repo}",
            "subscriptions_url": "https://api.github.com/users/octocat/subscriptions",
            "organizations_url": "https://api.github.com/users/octocat/orgs",
            "repos_url": "https://api.github.com/users/octocat/repos",
            "events_url": "https://api.github.com/users/octocat/events{/privacy}",
            "received_events_url": "https://api.github.com/users/octocat/received_events",
            "type": "User",
            "site_admin": false
          },
          "assignees": [
            {
              "login": "octocat",
              "id": 1,
              "avatar_url": "https://github.com/images/error/octocat_happy.gif",
              "gravatar_id": "",
              "url": "https://api.github.com/users/octocat",
              "html_url": "https://github.com/octocat",
              "followers_url": "https://api.github.com/users/octocat/followers",
              "following_url": "https://api.github.com/users/octocat/following{/other_user}",
              "gists_url": "https://api.github.com/users/octocat/gists{/gist_id}",
              "starred_url": "https://api.github.com/users/octocat/starred{/owner}{/repo}",
              "subscriptions_url": "https://api.github.com/users/octocat/subscriptions",
              "organizations_url": "https://api.github.com/users/octocat/orgs",
              "repos_url": "https://api.github.com/users/octocat/repos",
              "events_url": "https://api.github.com/users/octocat/events{/privacy}",
              "received_events_url": "https://api.github.com/users/octocat/received_events",
              "type": "User",
              "site_admin": false
            }
          ],
          "milestone": {
            "url": "https://api.github.com/repos/octocat/Hello-World/milestones/1",
            "html_url": "https://github.com/octocat/Hello-World/milestones/v1.0",
            "labels_url": "https://api.github.com/repos/octocat/Hello-World/milestones/1/labels",
            "id": 1002604,
            "number": 1,
            "state": "open",
            "title": "v1.0",
            "description": "Tracking milestone for version 1.0",
            "creator": {
              "login": "octocat",
              "id": 1,
              "avatar_url": "https://github.com/images/error/octocat_happy.gif",
              "gravatar_id": "",
              "url": "https://api.github.com/users/octocat",
              "html_url": "https://github.com/octocat",
              "followers_url": "https://api.github.com/users/octocat/followers",
              "following_url": "https://api.github.com/users/octocat/following{/other_user}",
              "gists_url": "https://api.github.com/users/octocat/gists{/gist_id}",
              "starred_url": "https://api.github.com/users/octocat/starred{/owner}{/repo}",
              "subscriptions_url": "https://api.github.com/users/octocat/subscriptions",
              "organizations_url": "https://api.github.com/users/octocat/orgs",
              "repos_url": "https://api.github.com/users/octocat/repos",
              "events_url": "https://api.github.com/users/octocat/events{/privacy}",
              "received_events_url": "https://api.github.com/users/octocat/received_events",
              "type": "User",
              "site_admin": false
            },
            "open_issues": 4,
            "closed_issues": 8,
            "created_at": "2011-04-10T20:09:31Z",
            "updated_at": "2014-03-03T18:58:10Z",
            "closed_at": "2013-02-12T13:22:01Z",
            "due_on": "2012-10-09T23:39:01Z"
          },
          "locked": true,
          "active_lock_reason": "too heated",
          "comments": 0,
          "pull_request": {
            "url": "https://api.github.com/repos/octocat/Hello-World/pulls/1347",
            "html_url": "https://github.com/octocat/Hello-World/pull/1347",
            "diff_url": "https://github.com/octocat/Hello-World/pull/1347.diff",
            "patch_url": "https://github.com/octocat/Hello-World/pull/1347.patch"
          },
          "closed_at": null,
          "created_at": "2011-04-22T13:33:48Z",
          "updated_at": "2011-04-22T13:33:48Z",
          "closed_by": {
            "login": "octocat",
            "id": 1,
            "avatar_url": "https://github.com/images/error/octocat_happy.gif",
            "gravatar_id": "",
            "url": "https://api.github.com/users/octocat",
            "html_url": "https://github.com/octocat",
            "followers_url": "https://api.github.com/users/octocat/followers",
            "following_url": "https://api.github.com/users/octocat/following{/other_user}",
            "gists_url": "https://api.github.com/users/octocat/gists{/gist_id}",
            "starred_url": "https://api.github.com/users/octocat/starred{/owner}{/repo}",
            "subscriptions_url": "https://api.github.com/users/octocat/subscriptions",
            "organizations_url": "https://api.github.com/users/octocat/orgs",
            "repos_url": "https://api.github.com/users/octocat/repos",
            "events_url": "https://api.github.com/users/octocat/events{/privacy}",
            "received_events_url": "https://api.github.com/users/octocat/received_events",
            "type": "User",
            "site_admin": false
          }
        }
        '));
        App::instance('GuzzleHttp\Client', $elzzug);

        /** @var Client $client */
        $client = App::make('App\Github\Client');
        /** @var Issue $issue */
        $issue = $client->createIssue('Test Issue', 'This is only a test.', collect());

        $this->assertInstanceOf(Issue::class, $issue);
        $this->assertEquals(1347, $issue->getNumber());
    }
}
