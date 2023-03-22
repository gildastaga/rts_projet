<?php

namespace Database\Seeders;
use App\Models\Eleves;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ElevesTableSeeder extends Seeder{
 /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $eleves=[
            [
                'nom'=>'eleve',
                'prenom'=> '1'
            ],
            [   'nom'=>'eleve',
                'prenom'=> '2'
            ],
            [   'nom'=>'eleve',
                'prenom'=> '3'
            ],
        ];
        foreach($eleves as $value){
            $eleve = new Eleves();
            $eleve->Nom = $value['nom'];
            $eleve->Prenom = $value['prenom'];
            $eleve->save();
        }
    }
}