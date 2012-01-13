<?php
namespace Club\ShopBundle\Tests\Controller;

use Club\UserBundle\Helper\TestCase as WebTestCase;

class AdminCouponControllerTest extends WebTestCase
{
  protected $client;

  public function __construct()
  {
    $this->client = static::createClient();
    $this->login($this->client);
  }

  public function testIndex()
  {
    $crawler = $this->client->request('GET', '/admin/shop/coupon');
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
  }

  public function testNew()
  {
    $crawler = $this->client->request('GET', '/admin/shop/coupon/new');
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

    $form = $crawler->selectButton('Save')->form();
    $crawler = $this->client->submit($form);
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

    $form = $crawler->selectButton('Save')->form(array(
      'coupon[value]' => '122',
      'coupon[coupon_key]' => date('Y-m-d')
    ));
    $crawler = $this->client->submit($form);
    $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
  }

  public function testExpire()
  {
    $crawler = $this->client->request('GET', '/admin/shop/coupon');
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

    $link = $crawler->selectLink('Expire')->link();
    $crawler = $this->client->click($link);
    $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
  }
}
