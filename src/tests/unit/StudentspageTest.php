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
    public function testRoute()
    {
        //$user = factory(\App\Models\User::class, 'user')->create();

        //$user = Auth::attempt(['email' => 'saxo4sam@gmail.com', 'password' => 'Faro1997']);
        //->actingAs($user)
        /*$this->visit('/reservation/students')
            ->type('sam.van.roy@student.ehb.be', 'username')
            ->type('Faro1997', 'password')
            ->press('Login')
            ->see('Students Page');*/

        /*factory(User::class, 50)->create()->each(function ($u) {
            $u->posts()->save(factory(Post::class)->make());
        });*/
        $user = factory(App\Models\User::class, 'valid-user')->create([
            'activated' => 1,
        ]);
        $this->visit('/reservation/students')
            ->type($user->username, 'username')
            ->type($user->password, 'password')
            ->press('Login')
            ->see('Students Page');
    }
}