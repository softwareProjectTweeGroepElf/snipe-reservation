<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProfessorPageTest extends TestCase
{

   use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRoute()
    {
       $this->visit('/reservation/professors')
           ->see('Professors Page');

    }
    public function testOutput()
    {
        $this->seeInDatabase('reservation_assets',['asset_id'=>'340157109','user_id'=>notNullValue()]);

    }
}
