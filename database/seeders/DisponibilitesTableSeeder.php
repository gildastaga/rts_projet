<?php

namespace Database\Seeders;
use App\Models\Disponibilite;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DisponibilitesTableSeeder extends Seeder{
 /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dispos=[
            [
                'jour'=>'2',
                'debut'=> Carbon::now(),
                'fin'=>Carbon::now(),
                'professeur_id'=>'2'
            ],
            [
                'jour'=>'6',
                'debut'=> Carbon::now(),
                'fin'=>Carbon::now(),
                'professeur_id'=>'2'
            ],
            [
                'jour'=>'2',
                'debut'=> Carbon::now(),
                'fin'=>Carbon::now(),
                'professeur_id'=>'2'
            ],
            [
                'jour'=>'4',
                'debut'=> Carbon::now(),
                'fin'=>Carbon::now(),
                'professeur_id'=>'1'
            ],
        ];
        foreach($dispos as $value){
            $dispo = new Disponibilite();
            $dispo->jour_semaine = $value['jour'];
            $dispo->debut = $value['debut'];
            $dispo->fin = $value['fin'];
            $dispo->professeur_id = $value['professeur_id'];
            $dispo->save();
        }
    }
}