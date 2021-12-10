<?php

use App\Models\Account;
use App\Models\Contact;
use App\Models\Organization;
use App\Models\User;
use App\Models\ProgramStudi;
use Database\Seeders\KelasSeeder;
use Database\Seeders\ProgramStudiSeeder;
use Database\Seeders\UsersSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
//        $account = Account::create(['name' => 'Acme Corporation']);
//
//        factory(User::class)->create([
//            'account_id' => $account->id,
//            'first_name' => 'John',
//            'last_name' => 'Doe',
//            'email' => 'johndoe@example.com',
//            'owner' => true,
//        ]);
//
//        factory(User::class, 5)->create(['account_id' => $account->id]);
//
//        $organizations = factory(Organization::class, 10)
//            ->create(['account_id' => $account->id]);
//
//        factory(Contact::class, 10)
//            ->create(['account_id' => $account->id])
//            ->each(function ($contact) use ($organizations) {
//                $contact->update(['organization_id' => $organizations->random()->id]);
//            });
        $this->call([
            UsersSeeder::class,
            ProgramStudiSeeder::class,
            KelasSeeder::class
        ]);
    }
}
