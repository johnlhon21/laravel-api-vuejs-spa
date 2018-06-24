<?php

use Illuminate\Database\Seeder;
use App\Security\Password;
use App\User;
use App\Client\KeyGenerator;
use App\Models\AuthClient;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    const DEFAULT_USER_ID = 1;

    public function run()
    {
        $user = User::find(self::DEFAULT_USER_ID);

        if ($user == null) {

            $password = new Password();
            $newUser = new User();

            $newUser->id = self::DEFAULT_USER_ID;
            $newUser->email = 'johnlhon21@gmail.com';
            $newUser->password = $password->hash('password');
            $newUser->first_name = 'Marlon';
            $newUser->last_name = 'Bagayawa';
            $newUser->postal_code = '4500';
            $newUser->address = 'Legazpi City';
            $newUser->contact_no = '09272652870';
            $newUser->save();

        }

        $authClient = AuthClient::where('user_id', self::DEFAULT_USER_ID)->first();

        if ($authClient == null) {
            $new = new AuthClient();
            $new->user_id = self::DEFAULT_USER_ID;
            $new->api_key = KeyGenerator::generate()->apiKey(self::DEFAULT_USER_ID);
            $new->save();
        }
    }
}
