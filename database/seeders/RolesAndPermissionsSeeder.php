<?php

namespace Database\Seeders;

use App\Models\Bagian;
use App\Models\Setting;
use App\Models\Taxi\Order;
use App\Models\Taxi\UserDriver;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();


        $default_user = [
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];

        DB::beginTransaction();
        try {
            $admin = User::create(array_merge([
                'email' => 'admin@gmail.com',
                'name' => 'admin web',
            ], $default_user));
            $user = User::create(array_merge([
                'email' => 'user@gmail.com',
                'name' => 'user',
            ], $default_user));
            $user1 =  User::create(array_merge([
                'email' => 'user1@gmail.com',
                'name' => 'user1',
            ], $default_user));
            $user2 = User::create(array_merge([
                'email' => 'user2@gmail.com',
                'name' => 'user2',
            ], $default_user));
            $user3 = User::create(array_merge([
                'email' => 'user3@gmail.com',
                'name' => 'user3',
            ], $default_user));
            $driver = User::create(array_merge([
                'email' => 'karel@kilat.fun',
                'name' => 'KAREL UNWARU',
            ], $default_user));

            $drivero =  UserDriver::create(
                [
                    'user_id' => $driver->id,
                    'fotokend' => "aSdTscInpDNo971Cd3tPbdP31N0QlgnVVaA3rxZs.png",
                    'nopolisi' => "DE 1957 AR",
                    'no_tlpn' => "085243628531",
                    'no_stnk' => "01874673",
                    'no_sim' => "21178103000024",
                    'jenis_mobil' => "AVANZA",
                    'nama_kepemilikan' => "KAREL UNWARU",
                    'kapasitas' => "8",
                    'no' => 1,
                    'aktif' => 1,
                ]
            );
            $driver1 = User::create(array_merge([
                'email' => 'ramli@kilat.fun',
                'name' => 'RAMLI LEUWERUNG',
            ], $default_user));

            UserDriver::create(
                [
                    'user_id' => $driver1->id,
                    'fotokend' => "aSdTscInpDNo971Cd3tPbdP31N0QlgnVVaA3rxZs.png",
                    'nopolisi' => "DE 1519 AH",
                    'no_tlpn' => "081240059333",
                    'no_stnk' => "01877561",
                    'no_sim' => "21178704 000020",
                    'jenis_mobil' => "AVANZA",
                    'nama_kepemilikan' => "RAMLI LEUWERUNG",
                    'kapasitas' => "8",
                    'no' => 2,
                    'aktif' => 1,
                ]
            );
            $driver2 = User::create(array_merge([
                'email' => 'ridwan@kilat.fun',
                'name' => 'MUHAMAD RIDWAN',
            ], $default_user));

            UserDriver::create(
                [
                    'user_id' => $driver2->id,
                    'fotokend' => "aSdTscInpDNo971Cd3tPbdP31N0QlgnVVaA3rxZs.png",
                    'nopolisi' => "DE 1120 B",
                    'no_tlpn' => "082311003942",
                    'no_stnk' => "16675695",
                    'no_sim' => "941221170028",
                    'jenis_mobil' => "AVANZA PENUMPANG",
                    'nama_kepemilikan' => "MUHAMAD RIDWAN",
                    'kapasitas' => "8",
                    'no' => 3,
                    'aktif' => 1,
                ]
            );
            $driver3 = User::create(array_merge([
                'email' => 'takoni@kilat.fun',
                'name' => 'TOKONIA LAKUANINE',
            ], $default_user));

            UserDriver::create(
                [
                    'user_id' => $driver3->id,
                    'fotokend' => "aSdTscInpDNo971Cd3tPbdP31N0QlgnVVaA3rxZs.png",
                    'nopolisi' => "DE 1120 B",
                    'no_tlpn' => "082111951386",
                    'no_stnk' => "03575387",
                    'no_sim' => "861021170723",
                    'jenis_mobil' => "AVANZA",
                    'nama_kepemilikan' => "DAMAREYES LIKUMAHU",
                    'kapasitas' => "8",
                    'no' => 4,
                    'aktif' => 1,
                ]
            );
            Order::create(
                [
                    'user_id' => $user->id,
                    'payment_id' => "6523663124f63",
                    'rute' => "Desa Saka",
                    'jumlah_penumpang' => 1,
                    'titikkor' => "-3.2997376780088175,128.956071138382",
                    'notlpn' => 242332,
                    'alamat' => "eworthy",
                    'status' => "selesai",
                    'layanan' => "Booking",
                    'total_price' => 1000000,
                    'snap_token' => "5b532069-bfb2-4769-acc9-46e20c62246a",
                    'date' => now()->format('Y-m-d')
                ]
            );
            Order::create(
                [
                    'user_id' => $user->id,
                    'payment_id' => "6523663124yfgf563",
                    'rute' => "Desa Saka",
                    'jumlah_penumpang' => 2,
                    'titikkor' => "-3.2997376780088175,128.956071138382",
                    'notlpn' => 242332,
                    'alamat' => "eworthy",
                    'status' => "Timeout",
                    'layanan' => "Booking",
                    'total_price' => 1000000,
                    'snap_token' => "5b532069-bfb2-4769-acc9-46e20c62246a",
                    'date' => now()->format('Y-m-d')
                ]
            );
            Order::create(
                [
                    'user_id' => $user1->id,
                    'payment_id' => "65236631rtyg24gf63",
                    'rute' => "Desa Saka",
                    'jumlah_penumpang' => 4,
                    'titikkor' => "-3.2997376780088175,128.956071138382",
                    'notlpn' => 242332,
                    'alamat' => "eworthy",
                    'status' => "Batal",
                    'layanan' => "Booking",
                    'total_price' => 1000000,
                    'snap_token' => "5b532069-bfb2-4769-acc9-46e20c62246a",
                    'date' => now()->format('Y-m-d')
                ]
            );
            Order::create(
                [
                    'user_id' => $user2->id,
                    'payment_id' => "6523663fghyr124gf63",
                    'rute' => "Desa Saka",
                    'jumlah_penumpang' => 3,
                    'titikkor' => "-3.2997376780088175,128.956071138382",
                    'notlpn' => 242332,
                    'alamat' => "eworthy",
                    'status' => "selesai",
                    'layanan' => "Booking",
                    'total_price' => 1000000,
                    'snap_token' => "5b532069-bfb2-4769-acc9-46e20c62246a",
                    'date' => now()->format('Y-m-d')
                ]
            );
            Order::create(
                [
                    'user_id' => $user3->id,
                    'payment_id' => "6523663124fh4fd63",
                    'rute' => "Desa Saka",
                    'jumlah_penumpang' => 5,
                    'titikkor' => "-3.2997376780088175,128.956071138382",
                    'notlpn' => 242332,
                    'alamat' => "eworthy",
                    'status' => "selesai",
                    'layanan' => "Booking",
                    'total_price' => 1000000,
                    'snap_token' => "5b532069-bfb2-4769-acc9-46e20c62246a",
                    'date' => now()->format('Y-m-d')
                ]
            );
            $roleAdmin = Role::create(['name' => 'admin']);

            Role::create(['name' => 'user']);
            Role::create(['name' => 'driver']);



            Permission::create(['name' => 'read']);
            Permission::create(['name' => 'create']);
            Permission::create(['name' => 'update']);
            Permission::create(['name' => 'delete']);
            Permission::create(['name' => 'admin']);

            $roleAdmin->givePermissionTo('read');
            $roleAdmin->givePermissionTo('create');
            $roleAdmin->givePermissionTo('update');
            $roleAdmin->givePermissionTo('delete');
            $roleAdmin->givePermissionTo('admin');


            $user->assignRole('user');
            $driver->assignRole('driver');
            $driver1->assignRole('driver');
            $driver2->assignRole('driver');
            $driver3->assignRole('driver');
            $admin->assignRole('admin');

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
