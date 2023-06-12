<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('users')->count() < 1) {
            $admins = [
                [
                    'name' => 'Administrator',
                    'email' => 'admin@mail.com',
                    'password' => Hash::make('secret'),
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'branch_id' => null,
                    'department_id' => 11,
                    'role' => \Role::ADMIN,
                    'telegram_chat_id' => ''
                ],
                [
                    'name' => 'Sobirov Otabek',
                    'email' => 'devsobirov@gmail.com',
                    'password' => Hash::make('secret'),
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'branch_id' => null,
                    'department_id' => 11,
                    'role' => \Role::ADMIN,
                    'telegram_chat_id' => ''
                ],
            ];

            $managers = [
                [
                    'name' => "Masharipov Farrux Umarovich",
                    'email' => 'masharipov@mail.com',
                    'password' => Hash::make('secret'),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'branch_id' => null,
                    'department_id' => 2,
                    'role' => \Role::HEAD_MANAGER,
                    'telegram_chat_id' => ''
                ],
                [
                    'name' => "Otajanov Safarboy Egamberdievich",
                    'email' => 'otajonov@mail.com',
                    'password' => Hash::make('secret'),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'branch_id' => null,
                    'department_id' => 3,
                    'role' => \Role::HEAD_MANAGER,
                    'telegram_chat_id' => ''
                ],[
                    'name' => "Ashirov  Baxtiyor Satimovich",
                    'email' => 'ashirov@mail.com',
                    'password' => Hash::make('secret'),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'branch_id' => null,
                    'department_id' => 4,
                    'role' => \Role::HEAD_MANAGER,
                    'telegram_chat_id' => ''
                ],[
                    'name' => "Matniyazov Umidbek Kadamovich",
                    'email' => 'matniyazov@mail.com',
                    'password' => Hash::make('secret'),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'branch_id' => null,
                    'department_id' => 5,
                    'role' => \Role::HEAD_MANAGER,
                    'telegram_chat_id' => ''
                ],[
                    'name' => "Siddikov Shavkat Ruzmetovich",
                    'email' => 'siddiqov@mail.com',
                    'password' => Hash::make('secret'),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'branch_id' => null,
                    'department_id' => 6,
                    'role' => \Role::HEAD_MANAGER,
                    'telegram_chat_id' => ''
                ],[
                    'name' => "Yuldashev Maqsudjon Gaibnazarovich",
                    'email' => 'yuldashev@mail.com',
                    'password' => Hash::make('secret'),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'branch_id' => null,
                    'department_id' => 7,
                    'role' => \Role::HEAD_MANAGER,
                    'telegram_chat_id' => ''
                ],[
                    'name' => "Qurambaeva Ruxsora Ilxambaevna",
                    'email' => 'hr@mail.com',
                    'password' => Hash::make('secret'),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'branch_id' => null,
                    'department_id' => 8,
                    'role' => \Role::HEAD_MANAGER,
                    'telegram_chat_id' => ''
                ],[
                    'name' => "Xidiyatullina Gulsanam Kamildjanovna ",
                    'email' => 'finans@mail.com',
                    'password' => Hash::make('secret'),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'branch_id' => null,
                    'department_id' => 9,
                    'role' => \Role::HEAD_MANAGER,
                    'telegram_chat_id' => ''
                ],[
                    'name' => "Yusupov Alisher Baxtiyarovich",
                    'email' => 'yusupov@mail.com',
                    'password' => Hash::make('secret'),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'branch_id' => null,
                    'department_id' => 10,
                    'role' => \Role::HEAD_MANAGER,
                    'telegram_chat_id' => ''
                ],[
                    'name' => "Karimov Jamol Ozod o'g'li",
                    'email' => 'karimov@mail.com',
                    'password' => Hash::make('secret'),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'branch_id' => null,
                    'department_id' => 11,
                    'role' => \Role::ADMIN,
                    'telegram_chat_id' => ''
                ],[
                    'name' => "Qilichov Qurbonboy Matyoqubovich",
                    'email' => 'qilichov@mail.com',
                    'password' => Hash::make('secret'),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'branch_id' => null,
                    'department_id' => 12,
                    'role' => \Role::ADMIN,
                    'telegram_chat_id' => ''
                ],
            ];

            $workers = [
                [
                    'name' => "Allaberganov Quvondiq Pulatovich",
                    'email' => 'urganch-sh@mail.com',
                    'password' => Hash::make('secret'),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'branch_id' => 1,
                    'department_id' => null,
                    'role' => \Role::REGIONAL_MANAGER,
                    'telegram_chat_id' => ''
                ],[
                    'name' => "Matmuratov Raxmatjon Baxtiyor o‘g‘li",
                    'email' => 'urganch-t@mail.com',
                    'password' => Hash::make('secret'),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'branch_id' => 2,
                    'department_id' => null,
                    'role' => \Role::REGIONAL_MANAGER,
                    'telegram_chat_id' => ''
                ],[
                    'name' => "Sharipboev Sanjarbek Komiljonovich ",
                    'email' => 'bogot@mail.com',
                    'password' => Hash::make('secret'),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'branch_id' => 3,
                    'department_id' => null,
                    'role' => \Role::REGIONAL_MANAGER,
                    'telegram_chat_id' => ''
                ],[
                    'name' => "Ibragimov Toxir Ilxamovich",
                    'email' => 'gurlan@mail.com',
                    'password' => Hash::make('secret'),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'branch_id' => 4,
                    'department_id' => null,
                    'role' => \Role::REGIONAL_MANAGER,
                    'telegram_chat_id' => ''
                ],[
                    'name' => "Baltaev Furkat Rustamovich",
                    'email' => 'kushkupir@mail.com',
                    'password' => Hash::make('secret'),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'branch_id' => 5,
                    'department_id' => null,
                    'role' => \Role::REGIONAL_MANAGER,
                    'telegram_chat_id' => ''
                ],[
                    'name' => "Sobirov Furkat Shuxratovich",
                    'email' => 'xazarasp@mail.com',
                    'password' => Hash::make('secret'),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'branch_id' => 6,
                    'department_id' => null,
                    'role' => \Role::REGIONAL_MANAGER,
                    'telegram_chat_id' => ''
                ],[
                    'name' => "Atajanov Sherzod Shuxratovich",
                    'email' => 'xiva-sh@mail.com',
                    'password' => Hash::make('secret'),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'branch_id' => 7,
                    'department_id' => null,
                    'role' => \Role::REGIONAL_MANAGER,
                    'telegram_chat_id' => ''
                ],[
                    'name' => "Ismoilov Masharip Muxammadsalay o‘g‘li",
                    'email' => 'xiva-t@mail.com',
                    'password' => Hash::make('secret'),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'branch_id' => 8,
                    'department_id' => null,
                    'role' => \Role::REGIONAL_MANAGER,
                    'telegram_chat_id' => ''
                ],[
                    'name' => "Umirov Ruslanbek Atabaevich",
                    'email' => 'xonqa@mail.com',
                    'password' => Hash::make('secret'),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'branch_id' => 9,
                    'department_id' => null,
                    'role' => \Role::REGIONAL_MANAGER,
                    'telegram_chat_id' => ''
                ],[
                    'name' => "Iskandarov Farrux Yo‘ldoshevich",
                    'email' => 'shovot@mail.com',
                    'password' => Hash::make('secret'),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'branch_id' => 10,
                    'department_id' => null,
                    'role' => \Role::REGIONAL_MANAGER,
                    'telegram_chat_id' => ''
                ],[
                    'name' => "Jumaniyozov Ruslon Kadamboevich",
                    'email' => 'yangiariq@mail.com',
                    'password' => Hash::make('secret'),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'branch_id' => 11,
                    'department_id' => null,
                    'role' => \Role::REGIONAL_MANAGER,
                    'telegram_chat_id' => ''
                ],[
                    'name' => "Ro‘zimov Xudaybergan Baltaevich",
                    'email' => 'yangibozor@mail.com',
                    'password' => Hash::make('secret'),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'branch_id' => 12,
                    'department_id' => null,
                    'role' => \Role::REGIONAL_MANAGER,
                    'telegram_chat_id' => ''
                ],[
                    'name' => "Abbazov Jamshidbek Xamdamovich",
                    'email' => 'tuproqqala@mail.com',
                    'password' => Hash::make('secret'),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'branch_id' => 13,
                    'department_id' => null,
                    'role' => \Role::REGIONAL_MANAGER,
                    'telegram_chat_id' => ''
                ],
            ];

            DB::table('users')->insert($admins);
            DB::table('users')->insert($managers);
            DB::table('users')->insert($workers);
        }
    }
}
