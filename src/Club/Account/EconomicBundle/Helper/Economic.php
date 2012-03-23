<?php

namespace Club\Account\EconomicBundle\Helper;

class Economic
{
  protected $container;
  protected $client;

  public function __construct($container)
  {
    $this->container = $container;
    $this->connect();
  }

  protected function findDebtor(\Club\UserBundle\Entity\User $user)
  {
    $this->debtor = $this->client->Debtor_FindByNumber(array('number' => $user->getMemberNumber()));
    if (count($this->debtor)) return $this->debtor->Debtor_FindByNumberResult;

    return $this->debtor;
  }

  public function updateDebtor($number, $name, $email, $phone)
  {
    $data = array(
      'Handle' => array('Number' => $number),
      'VatZone' => 'HomeCountry',
      'Name' => $name,
      'Email' => $email,
      'TelephoneAndFaxNumber' => $phone,
      'DebtorGroupHandle' => array('Number' => 1),
      'CurrencyHandle' => array('Code' => 'DKK'),
      'TermOfPaymentHandle' => array('Id' => 1),
      'IsAccessible' => true,
      'LayoutHandle' => array('Id' => 16),
    );

    $this->debtor = $this->client->Debtor_UpdateFromData(array('data' => $data))->Debtor_UpdateFromDataResult;
  }

  public function addDebtor(\Club\UserBundle\Entity\User $user)
  {
    $data = array(
      'VatZone' => 'HomeCountry',
      'Number' => $user->getMemberNumber(),
      'Name' => $user->getName(),
      'Email' => $user->getEmail(),
      'DebtorGroupHandle' => array('Number' => 1),
      'CurrencyHandle' => array('Code' => 'DKK'),
      'TermOfPaymentHandle' => array('Id' => 1),
      'IsAccessible' => true,
      'LayoutHandle' => array('Id' => 16),
    );

    $this->debtor = $this->client->Debtor_CreateFromData(array('data' => $data))->Debtor_CreateFromDataResult;
  }

  public function addOrder($order_number, $debtor_number, $name)
  {
    $data = array(
      'Number' => $order_number,
      'DebtorHandle' => array('Number' => $debtor_number),
      'DebtorName' => $name,
      'TermOfPaymentHandle' => array('Id' => 1),
      'Date' => date('Y-m-d').'T00:00:00',
      'DueDate' => date('Y-m-d').'T00:00:00',
      'ExchangeRate' => 1,
      'IsVatIncluded' => true,
      'DeliveryDate' => date('Y-m-d').'T00:00:00',
      'IsArchived' => false,
      'CurrencyHandle' => array('Code' => 'DKK'),
      'IsSent' => false,
      'NetAmount' => 0,
      'VatAmount' => 0,
      'GrossAmount' => 0,
      'Margin' => 0,
      'MarginAsPercent' => 0,
    );

    $this->order = $this->client->Order_CreateFromData(array(
      'data' => $data
    ))->Order_CreateFromDataResult;
  }

  public function addOrderItem($item_number, $quantity, $name, $unit_price)
  {
    $data = array(
      'OrderHandle' => $this->order,
      'Number' => $item_number,
      'DeliveryDate' => date('Y-m-d').'T00:00:00',
      'Quantity' => $quantity,
      'ProductHandle' => array('Number' => 120),
      'Description' => $name,
      'UnitHandle' => array('Number' => 1),
      'UnitNetPrice' => $unit_price,
      'DiscountAsPercent' => 0,
      'UnitCostPrice' => 0,
      'TotalNetAmount' => ($unit_price*$quantity),
      'TotalMargin' => 0,
      'MarginAsPercent' => 0
    );


    $item = $this->client->OrderLine_CreateFromData(array(
      'data' => $data
    ))->OrderLine_CreateFromDataResult;
    $this->order_items[] = $item;
  }

  public function getOrder()
  {
    return $this->order;
  }

  public function findOrder($number)
  {
    $this->order = $this->client->Order_FindByNumber(array('number' => $number));
    return $this->order;
  }

  public function getOrderNumber()
  {
    return $this->client->Order_GetNumber(array('orderHandle' => $this->order))->Order_GetNumberResult;
  }

  public function upgradeOrder()
  {
    $item = $this->client->OrderLine_CreateFromData(array(
      'data' => $data
    ))->OrderLine_CreateFromDataResult;

  }

  public function __destruct()
  {
    $this->disconnect();
  }

  protected function getAccount($account)
  {
    return $this->client->Account_FindByNumber(array(
      'number' => $account
    ))->Account_FindByNumberResult;
  }

  protected function getCurrencyByCode($currency)
  {
    return $this->client->Currency_FindByCode(array(
      'code' => $currency
    ))->Currency_FindByCodeResult;
  }

  public function addCashBookEntry(\Club\ShopBundle\Entity\PurchaseLog $purchase_log)
  {
    $user = $this->findDebtor($purchase_log->getOrder()->getUser());
    if (!count($user)) $user = $this->addDebtor($user);

    $contra_account = $this->getAccount($this->container->getParameter('club_account_economic.contraAccount'));
    $cashbook = $this->getCashBookByName($this->container->getParameter('club_account_economic.cashbook'));
    $currency = $this->getCurrencyByCode($this->container->getParameter('club_account_economic.currency'));

    $r = $this->client->CashBookEntry_Create(array(
      'type' => 'DebtorPayment',
      'cashBookHandle' => $cashbook,
      'debtorHandle' => $user,
      'contraAccountHandle' => $contra_account,
    ))->CashBookEntry_CreateResult;

    $entry = $this->getCashBookEntry($r);

    return $this->client->CashBookEntry_UpdateFromData(array(
      'data' => array(
        'Handle' => $r,
        'Type' => 'DebtorPayment',
        'CashBookHandle' => $cashbook,
        'DebtorHandle' => $user,
        'ContraAccountHandle' => $contra_account,
        'Date' => date('Y-m-d').'T00:00:00',
        'VoucherNumber' => $entry->VoucherNumber,
        'AmountDefaultCurrency' => '100',
        'Amount' => '100',
        'CurrencyHandle' => $currency,
        'Text' => 'Payment from '.$purchase_log->getOrder()->getUser()->getName()
      )))->CashBookEntry_UpdateFromDataResult;
  }

  public function getCashBookEntry($entry)
  {
    return $this->client->CashBookEntry_GetData(array(
      'entityHandle' => $entry
    ))->CashBookEntry_GetDataResult;
  }

  protected function getAllCurrencies()
  {
    $currencies = $this->client->Currency_GetAll()->Currency_GetAllResult;

    return $currencies;
  }

  protected function getCashBooks()
  {
    $cashbooks = $this->client->CashBook_GetAll();
    return $cashbooks;
  }

  protected function getCashBookByName($name)
  {
    $cashbook = $this->client->CashBook_FindByName(array(
      'name' => $name
    ));
    return $cashbook->CashBook_FindByNameResult;
  }

  protected function connect()
  {
    $this->client = new \SoapClient($this->container->getParameter('club_account_economic.economic_url'), array("trace" => 1, "exceptions" => 1));
    $this->client->Connect(array(
      'agreementNumber' => $this->container->getParameter('club_account_economic.agreement'),
      'userName'        => $this->container->getParameter('club_account_economic.username'),
      'password'        => $this->container->getParameter('club_account_economic.password')
    ));
  }

  protected function disconnect()
  {
    $this->client->Disconnect();
  }
}
