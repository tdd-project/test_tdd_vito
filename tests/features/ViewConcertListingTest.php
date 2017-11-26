<?php

use App\Concert;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ViewConcertListingTest extends TestCase
{

    use DatabaseMigrations;
    /** @test */
    
    public function user_can_view_a_published_concert_listing()
    {
        $concert = factory(Concert::class)->states('published')->create([
            'title'=>'The Red Chord',
            'subtitle'=>'with Animosity adn Lethargy',
            'date'=>Carbon::parse('December 13,2017 8:00pm'),
            'ticket_price'=>3250,
            'venue'=>'The Mosh pit',
            'venue_address'=>'123 example lane',
            'city'=>'laravel',
            'state'=>'on',
            'zip'=>'17916',
            'additional_information'=>'for tickets , call(111) 222-3333',
            'published_at'=>Carbon::parse('-1 week'),
        ]);

       
       $this->visit('/concerts/'.$concert->id);

       $this->see('The Red Chord');
       $this->see('with Animosity adn Lethargy');
       $this->see('December 13,2017');
       $this->see('8:00pm');
       $this->see('32.50');
       $this->see('The Mosh pit');
       $this->see('123 example lane');
       $this->see('laravel on 17916');
       $this->see('for tickets , call(111) 222-3333');
    
    }

    /** @test */

    function user_cannot_view_unpublished_concert_listings(){
        $concert= factory(Concert::class)->states('unpublished')->create();

        $this->get('/concerts/'.$concert->id);

        $this->assertResponseStatus(404);
    }
}
