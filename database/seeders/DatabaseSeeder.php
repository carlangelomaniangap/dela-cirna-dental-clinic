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
            'usertype' => 'admin',
            'name' => 'Dela Cirna',
            'email' => 'delacirna@bataandental.com',
            'password' => Hash::make('#Bataandental2024'),
            'gender' => null,
            'birthday' => null,
            'age' => null,
            'address' => 'Old National Road, Mulawin, Orani, Bataan',
            'phone' => '09486593662',
        ]);
        
        User::create([
            'usertype' => 'admin',
            'name' => 'Assistant',
            'email' => 'assistant@bataandental.com',
            'password' => Hash::make('#Bataandental2024'),
            'gender' => null,
            'birthday' => null,
            'age' => null,
            'address' => null,
            'phone' => null,
        ]);
    }
}
