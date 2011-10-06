<?php
namespace Club\UserBundle\Tests\Controller;

use Club\UserBundle\Helper\TestCase as WebTestCase;

class UserControllerTest extends WebTestCase
{
  public function testIndex()
  {
    $client = static::createClient();
    $this->login($client);

    $crawler = $client->request('GET', '/user');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());

    $form = $crawler->selectButton('Save')->form();
    $crawler = $client->submit($form);
    $this->assertEquals(200, $client->getResponse()->getStatusCode());

    $form = $crawler->selectButton('Save')->form(array(
      'user[profile][first_name]' => 'Tux'
    ));
    $crawler = $client->submit($form);
    $this->assertEquals(302, $client->getResponse()->getStatusCode());
  }
}
