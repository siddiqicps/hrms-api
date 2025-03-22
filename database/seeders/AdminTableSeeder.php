<?php
namespace Database\Seeders;

use App\Models\Admin;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // $user = Admin::create([
        //     'name' => 'Admin', 
        //     'UserName' => 'admin',
        //     'UserPassword' => Hash::make('aksolar@786'),
        //     'Status'    => 'y'
        // ]);
        // $user1 = Admin::create([
        //     'branch_id' => 2,
        //     'name' => 'Branch Delhi', 
        //     'UserName' => 'delhi',
        //     'UserPassword' => Hash::make('sol@del#2022'),
        //     'Status'    => 'y'
        // ]);
        // $user2 = Admin::create([
        //     'branch_id' => 3,
        //     'name' => 'Branch Chennai', 
        //     'UserName' => 'chennai',
        //     'UserPassword' => Hash::make('sol@chn#2022'),
        //     'Status'    => 'y'
        // ]);
        // $user3 = Admin::create([
        //     'branch_id' => 4,
        //     'name' => 'Branch Ramnad', 
        //     'UserName' => 'ramnad',
        //     'UserPassword' => Hash::make('sol@rmd#2022'),
        //     'Status'    => 'y'
        // ]);
        // $user4 = Admin::create([
        //     'branch_id' => 5,
        //     'name' => 'Branch Cuttack', 
        //     'UserName' => 'cuttack',
        //     'UserPassword' => Hash::make('sol@cut#2022'),
        //     'Status'    => 'y'
        // ]);
        // $user5 = Admin::create([
        //     'branch_id' => 6,
        //     'name' => 'Branch Dubai', 
        //     'UserName' => 'dubai',
        //     'UserPassword' => Hash::make('sol@dxb#2022'),
        //     'Status'    => 'y'
        // ]);
        $user = Admin::create([
            'name' => 'Nepal', 
            'UserName' => 'nepal',
            'UserPassword' => Hash::make('sol@Nep#2023'),
            'Status'    => 'y'
        ]);
    }
}
