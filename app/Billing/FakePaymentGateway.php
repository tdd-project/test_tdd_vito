<?php


namespace App\Billing;


class FakePaymentGateway
{
    private $charges;
    public function __construct(){
        $this->charges=collect();
    }

    public function getValidTestToken()
    {
        return "valid-token";
    }

    public function charge($amount, $token){
        $this->charges[]=$amount;
      }

    public function totalCharges(){
      return $this->charges->sum();
    }
}