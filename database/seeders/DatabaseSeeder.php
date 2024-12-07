<?php 
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

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
            'name' => 'Admin',
            'email' => 'admin@bataandental.com',
            'password' => Hash::make('#Bataandental2024'),
            'gender' => null,
            'birthday' => null,
            'age' => null,
            'address' => 'Old National Road, Mulawin, Orani, Bataan',
            'phone' => '09486593662',
        ]);

        DB::table('users')->insert([
        [
            'usertype' => 'patient',
            'name' => 'John Aldrin Portugal',
            'email' => 'portugaljohnaldrin30@gmail.com',
            'password' => Hash::make('password'),
            'gender' => 'Male',
            'birthday' => '2003-06-30',
            'age' => Carbon::parse('2003-06-30')->age,
            'address' => 'Lalawigan Samal Bataan',
            'phone' => '09439125640',
            'remember_token' => null,
        ],
        [
            'usertype' => 'patient',
            'name' => 'Chris',
            'email' => 'kitchriskat@gmail.com',
            'password' => Hash::make('password'),
            'gender' => 'Male',
            'birthday' => '2002-12-12',
            'age' => Carbon::parse('2002-12-12')->age,
            'address' => 'Gueco, Bagong paraiso, Orani, Bataan',
            'phone' => '09999030235',
            'remember_token' => null,
        ],
        [
            'usertype' => 'patient',
            'name' => 'Eco',
            'email' => 'marcelomicko14@gmail.com',
            'password' => Hash::make('password'),
            'gender' => 'Male',
            'birthday' => '2024-11-06',
            'age' => Carbon::parse('2024-11-06')->age,
            'address' => 'Hehe',
            'phone' => '09111111111',
            'remember_token' => null,
        ],
        [
            'usertype' => 'patient',
            'name' => 'Edwin Enrile',
            'email' => 'edwinenrile@gmail.com',
            'password' => Hash::make('password'),
            'gender' => 'Male',
            'birthday' => '1978-06-18',
            'age' => Carbon::parse('1978-06-18')->age,
            'address' => '63 Sto.Cristo St. Hermosa Bataan',
            'phone' => '09157443670',
            'remember_token' => null,
        ],
        [
            'usertype' => 'patient',
            'name' => 'Charmaigne Bongco',
            'email' => 'charmaignebongco@gmail.com',
            'password' => Hash::make('password'),
            'gender' => 'Female',
            'birthday' => '2002-11-27',
            'age' => Carbon::parse('2002-11-27')->age,
            'address' => '#69 Cattleya st. Tagumpay Orani, Bataan',
            'phone' => '09064634840',
            'remember_token' => null,
        ],
        [
            'usertype' => 'patient',
            'name' => 'Jenaica Abella',
            'email' => 'jenaicaabella@gmail.com',
            'password' => Hash::make('password'),
            'gender' => 'Female',
            'birthday' => '2000-06-18',
            'age' => Carbon::parse('2000-06-18')->age,
            'address' => 'Tamarind Ridge, orani Bataan',
            'phone' => '09157134637',
            'remember_token' => null,
        ],
        [
            'usertype' => 'patient',
            'name' => 'Sophia Ira Cubacub',
            'email' => 'sophiacubacub@gmail.com',
            'password' => Hash::make('password'),
            'gender' => 'Female',
            'birthday' => '2006-02-07',
            'age' => Carbon::parse('2006-02-07')->age,
            'address' => '1178 Mulawin Heights Ph. 2, Orani Bataan',
            'phone' => '09568676201',
            'remember_token' => null,
        ],
        [
            'usertype' => 'patient',
            'name' => 'Chris pangilinan',
            'email' => 'kitkit_chris@yahoo.com',
            'password' => Hash::make('password'),
            'gender' => 'Male',
            'birthday' => '2002-12-19',
            'age' => Carbon::parse('2002-12-19')->age,
            'address' => 'Gueco Bagong Paraiso, Orani Bataan',
            'phone' => '09999030235',
            'remember_token' => null,
        ],
        [
            'usertype' => 'patient',
            'name' => 'Dexter John Cueto',
            'email' => 'dpcueto@philstarmedia.com',
            'password' => Hash::make('password'),
            'gender' => 'Male',
            'birthday' => '1986-01-06',
            'age' => Carbon::parse('1986-01-06')->age,
            'address' => 'Time Square, Meadowoods Executive Village Bacoor, Cavite',
            'phone' => '09451175687',
            'remember_token' => null,
        ],
        [
            'usertype' => 'patient',
            'name' => 'lloyd galicia',
            'email' => 'polgas29@gmail.com',
            'password' => Hash::make('password'),
            'gender' => 'Male',
            'birthday' => '1980-05-29',
            'age' => Carbon::parse('1980-05-29')->age,
            'address' => 'Amvel Business Park, The Philippine Star Building, Cavite',
            'phone' => '09985504234',
            'remember_token' => null,
        ],
        [
            'usertype' => 'patient',
            'name' => 'Lloyd Galicia',
            'email' => 'polgas29b@gmail.com',
            'password' => Hash::make('password'),
            'gender' => 'Male',
            'birthday' => '1980-05-01',
            'age' => Carbon::parse('1980-05-01')->age,
            'address' => 'Cavite',
            'phone' => '09985504751',
            'remember_token' => null,
        ],
        [
            'usertype' => 'patient',
            'name' => 'Carl Angelo Matias Maniangap',
            'email' => 'carlangelommaniangap@gmail.com',
            'password' => Hash::make('password'),
            'gender' => 'Male',
            'birthday' => '1997-01-23',
            'age' => Carbon::parse('1997-01-23')->age,
            'address' => 'Samal, Bataan',
            'phone' => '09158430714',
            'remember_token' => null,
        ],
        [
            'usertype' => 'patient',
            'name' => 'John Alfer Mendoza',
            'email' => 'mendozajohnalfer2@gmail.com',
            'password' => Hash::make('password'),
            'gender' => 'Male',
            'birthday' => '2024-08-01',
            'age' => Carbon::parse('2024-08-01')->age,
            'address' => 'Orani, Bataan',
            'phone' => '09111111111',
            'remember_token' => null,
        ], 
        [
            'usertype' => 'patient',
            'name' => 'jerwin navarro',
            'email' => 'navarrojerwin1234@gmail.com',
            'password' => Hash::make('password'),
            'gender' => 'Male',
            'birthday' => '2001-05-22',
            'age' => Carbon::parse('2001-05-22')->age,
            'address' => 'miray cataning balanga city bataan',
            'phone' => '09853676487',
            'remember_token' => null,
        ],
        [
            'usertype' => 'patient',
            'name' => 'Juliana Jaime',
            'email' => 'butakalagruan@gmail.com',
            'password' => Hash::make('password'),
            'gender' => 'Female',
            'birthday' => '2004-07-01',
            'age' => Carbon::parse('2004-07-01')->age,
            'address' => 'Cupang Bataan',
            'phone' => '09285436257',
            'remember_token' => null,
        ],
        [
            'usertype' => 'patient',
            'name' => 'Jheana Jelaine Javier',
            'email' => 'jakejareen@gmail.com',
            'password' => Hash::make('password'),
            'gender' => 'Female',
            'birthday' => '2005-09-28',
            'age' => Carbon::parse('2005-09-28')->age,
            'address' => 'cupang proper balanga bataan',
            'phone' => '09583612574',
            'remember_token' => null,
        ],
        [
            'usertype' => 'patient',
            'name' => 'Huwie Jensen',
            'email' => 'seokjin@gmail.com',
            'password' => Hash::make('password'),
            'gender' => 'Female',
            'birthday' => '2004-11-08',
            'age' => Carbon::parse('2004-11-08')->age,
            'address' => 'Abucay Bataan',
            'phone' => '09583612574',
            'remember_token' => null,
        ],
        [
            'usertype' => 'patient',
            'name' => 'Eric Almoguerra',
            'email' => 'eric.almoguerra@gmail.com',
            'password' => Hash::make('password'),
            'gender' => 'Male',
            'birthday' => '2003-06-30',
            'age' => Carbon::parse('2003-06-30')->age,
            'address' => 'Lalawigan Samal Bataan',
            'phone' => '09768212341',
            'remember_token' => null,
        ],
        [
            'usertype' => 'patient',
            'name' => 'Karl Allan Peralta',
            'email' => 'peraltakarlallan30@gmail.com',
            'password' => Hash::make('password'),
            'gender' => 'Male',
            'birthday' => '2002-09-30',
            'age' => Carbon::parse('2002-09-30')->age,
            'address' => 'CDA, BLDG 1',
            'phone' => '09608232721',
            'remember_token' => null,
        ],
    ]);

        // User::create([
        //     'usertype' => 'admin',
        //     'name' => 'Assistant',
        //     'email' => 'assistant@example.com',
        //     'password' => Hash::make('#Bataandental2024'),
        //     'gender' => null,
        //     'birthday' => null,
        //     'age' => null,
        //     'address' => null,
        //     'phone' => null,
        // ]);
    }
}
