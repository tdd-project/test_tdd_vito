<?php

use App\Concert;
use App\Billing\FakePaymentGateway;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PurchaseTicketsTest extends TestCase
{
    use DatabaseMigrations;
    /** @test */
    
    public function customer_can_purchase_concert_tickets()
    {
        $paymentGateway=new FakePaymentGateway;

        //arrange
        $concert=factory(Concert::class)->create(['ticket_price'=>3250]);
        //act

        $this->json('POST',"/concerts/{$concert->id}/orders",[
            'email'=>'john@example.com',
            'ticket_quantity'=>3,
            'payment_token'=>$paymentGateway->getValidTestToken(),
        ]);

        //Assert
        $this->assertEquals(9750, $paymentGateway->totalCharges());


        $order=$concert->orders()->where('email','john@example.com')->first();
        $this->assertNotNull($order);
      //  $this->assertEquals(3,$order->tickets->count());
    }
 
}
