<?php
namespace Club\TeamBundle\Tests\Controller;

use Club\UserBundle\Helper\TestCase as WebTestCase;

class AdminTeamControllerTest extends WebTestCase
{
  protected $client;

  public function __construct()
  {
    $this->client = static::createClient();
    $this->login($this->client);
  }

  public function testIndex()
  {
    $crawler = $this->client->request('GET', '/admin/team/team');
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
  }

  public function testNew()
  {
    $crawler = $this->client->request('GET', '/admin/team/team/new');
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

    $form = $crawler->selectButton('Save')->form(array(
      'team[team_name]' => 'Test',
      'team[description]' => 'Test',
      'team[penalty]' => '50'
    ));
    $crawler = $this->client->submit($form);
    $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

    $crawler = $this->client->request('GET', '/admin/team/team/new');
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

    $form = $crawler->selectButton('Save')->form(array(
      'team[team_name]' => 'Test2',
      'team[description]' => 'Test2',
      'team[penalty]' => '50'
    ));
    $crawler = $this->client->submit($form);
    $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
  }

  public function testDelete()
  {
    $crawler = $this->client->request('GET', '/admin/team/team');
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

    $links = $crawler->selectLink('Delete')->links();
    $crawler = $this->client->click(end($links));
    $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
  }
}
