<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PoliticianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table("politicians")->insert(["id" => "2","created_at" => "2022-01-26 09:27:12","updated_at" => "2022-01-26 09:27:12","name" => "Robert","surname" => "Fico","nick" => "robertficosk","image" => "https://scontent-prg1-1.xx.fbcdn.net/v/t39.30808-1/c187.0.480.480a/p480x480/241821319_401309894686650_5543777500043057727_n.jpg?_nc_cat=1&ccb=1-5&_nc_sid=c6021c&_nc_ohc=czJDBWFIIm8AX8uva-e&_nc_ht=scontent-prg1-1.xx&oh=00_AT9wYjcQFKVCYGOx9O_Zs2WlACpTOR3y4nbRrNij3id_QA&oe=62033B30",]);
        DB::table("politicians")->insert(["id" => "3","created_at" => "2022-01-31 11:42:48","updated_at" => "2022-01-31 11:42:48","name" => "Ľuboš","surname" => "Blaha","nick" => "LBlaha","image" => "https://scontent-prg1-1.xx.fbcdn.net/v/t39.30808-1/p480x480/242063125_394303958733558_8158245752672204010_n.png?_nc_cat=1&ccb=1-5&_nc_sid=c6021c&_nc_ohc=sJp4K-mR7GcAX_Wq4tN&_nc_ht=scontent-prg1-1.xx&oh=00_AT-UXBzQPQ76_1oHxbeLeGoY-8VvHcY3K3vqZU9DjNUe4w&oe=62042634",]);
        DB::table("politicians")->insert(["id" => "4","created_at" => "2022-01-31 11:48:29","updated_at" => "2022-01-31 11:48:29","name" => "Eduard","surname" => "Chmelár","nick" => "ChmelarEduard","image" => "https://scontent-prg1-1.xx.fbcdn.net/v/t39.30808-1/c0.0.148.148a/p148x148/271270034_5009992615699257_7531502959052034709_n.jpg?_nc_cat=110&ccb=1-5&_nc_sid=1eb0c7&_nc_ohc=Dv_fHJ1Jq-UAX_6Ntyf&_nc_ht=scontent-prg1-1.xx&oh=00_AT9xiPWTn6qi52WMa7HR4r9ojxL1sd2-puSp2MXPwbF3og&oe=62038216",]);
        DB::table("politicians")->insert(["id" => "5","created_at" => "2022-01-31 13:54:44","updated_at" => "2022-01-31 13:54:44","name" => "Milan","surname" => "Mazurek","nick" => "MilanMazurek.Republika","image" => "https://scontent-prg1-1.xx.fbcdn.net/v/t39.30808-1/p480x480/242085680_407201580773133_2492210267751382043_n.jpg?_nc_cat=1&ccb=1-5&_nc_sid=c6021c&_nc_ohc=UPEPVnMQIiMAX-nmAW0&_nc_ht=scontent-prg1-1.xx&oh=00_AT_FvPF0Up-BnAVZx-dGuNWh4nP9nWYNgyuvnCzpoLmO6A&oe=61FD2245",]);
        DB::table("politicians")->insert(["id" => "6","created_at" => "2022-01-31 13:57:07","updated_at" => "2022-01-31 13:57:07","name" => "Milan","surname" => "Uhrík","nick" => "ing.milan.uhrik","image" => "https://scontent-prg1-1.xx.fbcdn.net/v/t39.30808-1/p480x480/269967651_511286883694197_5079872873190238126_n.jpg?_nc_cat=1&ccb=1-5&_nc_sid=c6021c&_nc_ohc=4jmtXkTLUT4AX8VCRpy&_nc_ht=scontent-prg1-1.xx&oh=00_AT9ywktT-f8sdzzZzTUQi6yHqsB7iXYGhdW_IENDvMPEdQ&oe=61FCB661",]);

//        DB::table('politicians')->insert([
//            'id' => '',
//            'created_at' => '',
//            'updated_at' => '',
//            'name' => '',
//            'surname' => '',
//            'nick' => '',
//            'image' => '',
//        ]);
//
//        DB::table('politicians')->insert([
//            'id' => '',
//            'text' => '',
//            'date' => '',
//            'edit' => '',
//            'img' => '',
//        ]);
    }
}
