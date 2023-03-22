<?php

namespace Database\Seeders;
use App\Models\RendezVous;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class RendezVousTableSeeder extends Seeder{
 /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rendezvous=[
            [
                    'Debut'=> '2022-06-21 14:42:07',
                    'Fin' => '2022-06-21 19:30:00',
                    'professeur_id'=> 1,
                    'eleve_id'=> 2,
                
            ],
            [
                'Debut'=> '2022-06-21 14:42:07',
                'Fin' => '2022-06-21 19:30:00',
                'professeur_id'=>2,
                'eleve_id'=>2

            ],
            [
                'Debut'=> '2022-06-21 14:42:07',
                'Fin' => '2022-06-21 19:30:00',
                'professeur_id'=>1,
                'eleve_id'=>2
            ],
        ];
        foreach($rendezvous as $value){
            $rendezvous = new RendezVous();
            $rendezvous->debut = $value['debut'];
            $rendezvous->fin = $value['fin'];
            $rendezvous->professeur_id = $value['professeur_id'];
            $rendezvous->eleve_id = $value['eleve_id'];;
            $rendezvous->save();
        }
    }
}