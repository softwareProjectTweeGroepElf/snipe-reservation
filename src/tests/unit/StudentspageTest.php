<?php
/**
 * Created by PhpStorm.
 * User: Sam Van Roy
 * Date: 12/22/2016
 * Time: 9:58 AM
 */

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;

class StudentspageTest extends TestCase
{

    //use DatabaseMigrations;
    public function login(){
        $faker = Faker\Factory::create();
        $user = factory(App\Models\User::class, 'valid-user')->create([
            'activated' => 1,
            'api_token' => $faker->text,
        ]);

        return $user;
    }

    public function testRouteStudents(){
        $user = $this->login();
        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->visit('/reservation/students')
            ->see('Students Page');

        $this->visit('/reservation/students')
            ->see('Students Page');
    }

    public function testSeeRequestStudents(){
        $this->testRequestAssetStudents();
        $user = Auth::user();

        $this->visit('/reservation/students')
            ->see($user->first_name);
    }
    public function testRequestAssetStudents(){
        $faker = Faker\Factory::create();
        $data = $faker->text;

        $this->testRouteStudents();
        //$asset = factory(\App\Models\Asset::class, 'asset')->create();
        //$this->select(1, 'asset_list')
          $this->type($data, 'subject')
            ->type($data, 'note')
            ->press('Submit');

        $this->seeInDatabase('reservation_requests', [
            'subject' => $data,
            'note' => $data,
        ]);
    }
    /*public function testRouteRedirection()
    {
        //$user = factory(\App\Models\User::class, 'user')->create();

        $this->visit('/reservation/students')
            ->type('dummyUser', 'username')
            ->type('dummyUser', 'password')
            ->press('Login')
            ->see('Students Page');

        factory(User::class, 50)->create()->each(function ($u) {
            $u->posts()->save(factory(Post::class)->make());
        });
        $user = factory(App\Models\User::class, 'valid-user')->create([
            'activated' => 1,
        ]);
        $this->visit('/reservation/students')
            ->type($user->username, 'username')
            ->type($user->password, 'password')
            ->press('Login')
            ->see('Students Page');
    }*/




}