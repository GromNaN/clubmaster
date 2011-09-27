<?php
namespace Club\UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminUserControllerTest extends WebTestCase
{
  public function testIndex()
  {
    $client = static::createClient(array(), array(
      'PHP_AUTH_USER' => '10',
      'PHP_AUTH_PW' => '1234'
    ));
    $crawler = $client->request('GET', '/admin/user');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());
  }

  public function testNew()
  {
    $client = static::createClient(array(), array(
      'PHP_AUTH_USER' => '10',
      'PHP_AUTH_PW' => '1234'
    ));
    $crawler = $client->request('GET', '/admin/user/new');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());

    $form = $crawler->selectButton('Save')->form(array(
      'admin_user[profile][first_name]' => 'John',
      'admin_user[profile][last_name]' => 'Doe',
      'admin_user[profile][profile_address][street]' => 'Clubby Strasse 14',
      'admin_user[profile][profile_address][postal_code]' => '9000',
      'admin_user[profile][profile_address][city]' => 'Aalborg',
      'admin_user[profile][profile_email][email_address]' => 'user@example.com',
      'admin_user[profile][profile_phone][number]' => '+45 80808080',
    ));
    $crawler = $client->submit($form);
    $this->assertEquals(302, $client->getResponse()->getStatusCode());
  }
}
