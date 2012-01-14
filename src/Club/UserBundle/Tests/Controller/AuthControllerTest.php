<?php
namespace Club\UserBundle\Tests\Controller;

use Club\UserBundle\Helper\TestCase as WebTestCase;

class AuthControllerTest extends WebTestCase
{
  public function testForgot()
  {
    $client = static::createClient();
    $crawler = $client->request('GET', '/auth/forgot');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());

    $form = $crawler->selectButton('Send Password')->form(array(
      'form[username]' => '10',
    ));
    $crawler = $client->submit($form);
    $this->assertEquals(302, $client->getResponse()->getStatusCode());
  }
}
