<?php 
namespace Database\Seeders;

use App\Models\User;
use App\Models\Patientlist;
use App\Models\PaymentInfo;
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
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        
        User::create([
            'usertype' => 'patient',
            'name' => 'Patient',
            'email' => 'patient@example.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'usertype' => 'dentistrystudent',
            'name' => 'Dentistry Student',
            'email' => 'dentistrystudent@example.com',
            'password' => Hash::make('password'),
        ]);

        // Seed patient lists
       

        $patients = [
            // ['firstname' => 'John',
            // 'lastname' => 'Smith',
            // 'birthday' => '1999-1-1',
            // 'age' => 25,
            // 'gender' => 'Male',
            // 'phone' => '09123456789',
            // 'address' => '123 Maple Street',
            // 'email' => 'johnsmith@example.com'],
            // ['firstname' => 'Emily',
            // 'lastname' => 'Johnson',
            // 'birthday' => '2003-2-14',
            // 'age' => 21,
            // 'gender' => 'Female',
            // 'phone' => '09123456789',
            // 'address' => '456 El Street',
            // 'email' => 'emilyjohnson@example.com'],
        ];

        foreach ($patients as $patient) {
            Patientlist::create($patient);
        }

        // Seed payment info
        PaymentInfo::truncate();

        $payments = [
            // ['patient' => 'Emily', 'description' => 'Cleaning', 'amount' => 11000, 'balance' => 2000, 'date' => '2024-02-28'],
            // // Add more payments here...
            // ['patient' => 'Olivia', 'description' => 'Orthodontic Treatment', 'amount' => 25000, 'balance' => 11000, 'date' => '2024-02-10'],
        ];

        foreach ($payments as $payment) {
            PaymentInfo::create($payment);
        }

       
    }
}
