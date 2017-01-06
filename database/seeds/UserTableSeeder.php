<?php

use Illuminate\Database\Seeder;
use App\Models\User;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class)->times(50)->make();
        User::insert($users->toArray());

        $user = User::find(1);
        $user->name = 'zhangxinyu';
        $user->email = '583145128@qq.com';
        $user->password = '123456';
        $user->is_admin = true;
        $user->activated=true;
        $user->save();
    }
}
