<?php

namespace Database\Seeders;
use App\Models\Professeurs;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ProfesseurTableSeeder extends Seeder{
 /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prof=[
            [
                'nom'=>'jean',
                'prenom'=> 'paul'
            ],
            [   'nom'=>'taga',
                'prenom'=> 'gildas'
            ],
            [   'nom'=>'jean',
                'prenom'=> 'pierre'
            ],
        ];
        foreach($prof as $value){
            $prof = new Professeurs();
            $prof->Nom = $value['nom'];
            $prof->Prenom = $value['prenom'];
            $prof->save();
        }
    }

}