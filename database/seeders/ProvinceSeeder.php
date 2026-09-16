<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Province\App\Models\Province;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provinceModel = new Province();
        if ($provinceModel->count() === 0) {
            $provinces = [
                array('id' => '1', 'name' => 'آذربایجان شرقی', 'slug' => 'East Azerbaijan', 'latitude' => '37.90357330', 'longitude' => '46.26821090', 'is_active' => '1'),
                array('id' => '2', 'name' => 'آذربایجان غربی', 'slug' => 'West Azerbaijan', 'latitude' => '37.45500620', 'longitude' => '45.00000000', 'is_active' => '1'),
                array('id' => '3', 'name' => 'اردبیل', 'slug' => 'Ardabil', 'latitude' => '38.48532760', 'longitude' => '47.89112090', 'is_active' => '1'),
                array('id' => '4', 'name' => 'اصفهان', 'slug' => 'Isfahan', 'latitude' => '32.65462750', 'longitude' => '51.66798260', 'is_active' => '1'),
                array('id' => '5', 'name' => 'البرز', 'slug' => 'Alborz', 'latitude' => '35.99604670', 'longitude' => '50.92892460', 'is_active' => '1'),
                array('id' => '6', 'name' => 'ایلام', 'slug' => 'Ilam', 'latitude' => '33.29576180', 'longitude' => '46.67053400', 'is_active' => '1'),
                array('id' => '7', 'name' => 'بوشهر', 'slug' => 'Bushehr', 'latitude' => '28.92338370', 'longitude' => '50.82031400', 'is_active' => '1'),
                array('id' => '8', 'name' => 'تهران', 'slug' => 'Tehran', 'latitude' => '35.69611100', 'longitude' => '51.42305600', 'is_active' => '1'),
                array('id' => '9', 'name' => 'چهارمحال و بختیاری', 'slug' => 'Chaharmahal and Bakhtiari ', 'latitude' => '31.96143480', 'longitude' => '50.84563230', 'is_active' => '1'),
                array('id' => '10', 'name' => 'خراسان جنوبی', 'slug' => 'South Khorasan', 'latitude' => '32.51756430', 'longitude' => '59.10417580', 'is_active' => '1'),
                array('id' => '11', 'name' => 'خراسان رضوی', 'slug' => 'Razavi Khorasan', 'latitude' => '35.10202530', 'longitude' => '59.10417580', 'is_active' => '1'),
                array('id' => '12', 'name' => 'خراسان شمالی', 'slug' => 'North Khorasan', 'latitude' => '37.47103530', 'longitude' => '57.10131880', 'is_active' => '1'),
                array('id' => '13', 'name' => 'خوزستان', 'slug' => 'Khuzestan', 'latitude' => '31.43601490', 'longitude' => '49.04131200', 'is_active' => '1'),
                array('id' => '14', 'name' => 'زنجان', 'slug' => 'Zanjan', 'latitude' => '36.50181850', 'longitude' => '48.39881860', 'is_active' => '1'),
                array('id' => '15', 'name' => 'سمنان', 'slug' => 'Semnan', 'latitude' => '35.22555850', 'longitude' => '54.43421380', 'is_active' => '1'),
                array('id' => '16', 'name' => 'سیستان و بلوچستان', 'slug' => 'Sistan and Baluchestan ', 'latitude' => '27.52999060', 'longitude' => '60.58206760', 'is_active' => '1'),
                array('id' => '17', 'name' => 'فارس', 'slug' => 'Fars', 'latitude' => '29.10438130', 'longitude' => '53.04589300', 'is_active' => '1'),
                array('id' => '18', 'name' => 'قزوین', 'slug' => 'Qazvin', 'latitude' => '36.08813170', 'longitude' => '49.85472660', 'is_active' => '1'),
                array('id' => '19', 'name' => 'قم', 'slug' => 'Qom', 'latitude' => '34.63994430', 'longitude' => '50.87594190', 'is_active' => '1'),
                array('id' => '20', 'name' => 'كردستان', 'slug' => 'Kurdistan', 'latitude' => '35.95535790', 'longitude' => '47.13621250', 'is_active' => '1'),
                array('id' => '21', 'name' => 'كرمان', 'slug' => 'Kerman', 'latitude' => '30.28393790', 'longitude' => '57.08336280', 'is_active' => '1'),
                array('id' => '22', 'name' => 'كرمانشاه', 'slug' => 'Kermanshah', 'latitude' => '34.31416700', 'longitude' => '47.06500000', 'is_active' => '1'),
                array('id' => '23', 'name' => 'کهگیلویه و بویراحمد', 'slug' => 'Kohgiluyeh and Boyer-Ahmad ', 'latitude' => '30.65094790', 'longitude' => '51.60525000', 'is_active' => '1'),
                array('id' => '24', 'name' => 'گلستان', 'slug' => 'Golestan', 'latitude' => '37.28981230', 'longitude' => '55.13758340', 'is_active' => '1'),
                array('id' => '25', 'name' => 'گیلان', 'slug' => 'Gilan', 'latitude' => '37.11716170', 'longitude' => '49.52799960', 'is_active' => '1'),
                array('id' => '26', 'name' => 'لرستان', 'slug' => 'Lorestan', 'latitude' => '33.58183940', 'longitude' => '48.39881860', 'is_active' => '1'),
                array('id' => '27', 'name' => 'مازندران', 'slug' => 'Mazandaran', 'latitude' => '36.22623930', 'longitude' => '52.53186040', 'is_active' => '1'),
                array('id' => '28', 'name' => 'مركزی', 'slug' => 'Markazi', 'latitude' => '34.30559', 'longitude' => '49.4251', 'is_active' => '1'),
                array('id' => '29', 'name' => 'هرمزگان', 'slug' => 'Hormozgan', 'latitude' => '27.13872300', 'longitude' => '55.13758340', 'is_active' => '1'),
                array('id' => '30', 'name' => 'همدان', 'slug' => 'Hamadan', 'latitude' => '34.76079990', 'longitude' => '48.39881860', 'is_active' => '1'),
                array('id' => '31', 'name' => 'یزد', 'slug' => 'Yazd', 'latitude' => '32.10063870', 'longitude' => '54.43421380', 'is_active' => '1')
            ];
            foreach ($provinces as $province) {
                $provinceModel->insert([
                    'name' => $province['name'],
                    'slug' => str_replace(' ','-',$province['slug']),
                    'latitude' => $province['latitude'],
                    'longitude' => $province['longitude'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ]);
            }
        }
    }
}
