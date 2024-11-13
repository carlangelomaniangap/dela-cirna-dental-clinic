<?php 
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed users

        User::create([
            'dentalclinic_id' => null,
            'usertype' => 'superadmin',
            'name' => 'Admin',
            'email' => 'admin@bataandental.com',
            'password' => Hash::make('#Bataandental2024'),
            'gender' => null,
            'birthday' => null,
            'age' => null,
            'address' => null,
            'phone' => null,
        ]);
    }
}
