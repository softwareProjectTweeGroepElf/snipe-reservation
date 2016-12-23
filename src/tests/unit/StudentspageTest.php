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

class StudentspageTest extends TestCase
{

//->assertRedirectedToRoute($name, $parameters = [], $with = []);
    public function testRouteRedirection()
    {
        //$user = factory(\App\Models\User::class, 'user')->create();

        $this->visit('/reservation/students')
            ->type('dummyUser', 'username')
            ->type('dummyUser', 'password')
            ->press('Login')
            ->see('Students Page');

        /*factory(User::class, 50)->create()->each(function ($u) {
            $u->posts()->save(factory(Post::class)->make());
        });*/
        /*$user = factory(App\Models\User::class, 'valid-user')->create([
            'activated' => 1,
        ]);
        $this->visit('/reservation/students')
            ->type($user->username, 'username')
            ->type($user->password, 'password')
            ->press('Login')
            ->see('Students Page');*/
    }

    public function testRoute(){
        $this->visit('/login')
            ->type('dummyUser', 'username')
            ->type('dummyUser', 'password')
            ->press('Login');

        $this->visit('/reservation/students')
            ->see('Students Page');
    }

}