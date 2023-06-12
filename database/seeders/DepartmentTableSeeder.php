<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentTableSeeder extends Seeder
{
    public static array $departmentList = [
        ['name' => 'Direktor', 'prefix' => 'direktor'],
        ['name' => "Boshliq o‘rinbosari, Bosh arxitektor", 'prefix' => 'bosh_arxitektor'],
        ['name' => "Arxitektura va hududlarni rivojlantirishni rejalashtirish sho‘basi", 'prefix' => 'rejalashtirish'],
        ['name' => "Tuman (shahar) Qurilish va uy-joy kommunal xo‘jaligi bo‘limlari faoliyatini muvofiqlashtirish sho‘basi", 'prefix' => 'kommunal'],
        ['name' => "Ko‘p kvartirali uylarni boshqarish tizimini rivojlantirish va renovatsiya loyihalarini amalga oshirish sho‘basi", 'prefix' => "renovatsiya"],
        ['name' => "Ichimlik suvi, oqova suv va issiqlik ta’minoti tizimlarini rivojlantirish sho‘basi", 'prefix' => "suv_issiqlik"],
        ['name' => "Yuridik bo'lim", 'prefix' => "yurist"],
        ['name' => "Inson resurslarini boshqarish", 'prefix' => "hr"],
        ['name' => "Buxgalteriya", 'prefix' => "buxgalteriya"],
        ['name' => "Devonxona va ijro nazorati", 'prefix' => "devonxona"],
        ['name' => "Raqamli texnologiyalar", 'prefix' => "it"],
        ['name' => "Murojaatlar va dispecherlik xizmati sho‘basi", 'prefix' => "dispecher"],
    ];

    public function run(): void
    {
        if (DB::table('departments')->count() < 1) {
            DB::table('departments')->insert(self::$departmentList);
        }
    }
}
