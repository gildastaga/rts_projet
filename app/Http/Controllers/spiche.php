<?php
   /* Online PHP Compiler (Interpreter) and Editor */
    $dispo_dates = array(
        array(
            "debut" => new Datetime("Friday 2022-06-03 08:30:00"),
            "fin" =>new  Datetime("Friday 2022-06-03 12:30:00"),
        ),
        array(
            "debut" =>new Datetime("Monday 2022-06-06 13:30:00"),
            "fin" =>new Datetime("Monday 2022-06-06 16:30:00"),
        ),
        array(
            "debut" =>new Datetime("Tuesday 2022-06-07 10:30:00"),
            "fin" =>new Datetime("Tuesday 2022-06-07 13:30:00"),
        ),
        array(
            "debut" =>new Datetime("Tuesday 2022-06-07 15:30:00"),
            "fin" =>new Datetime("Tuesday 2022-06-07 19:30:00"),
        ),
    );
    $rdvs = array(
        array(
            "debut"=>new  Datetime("2022-06-07 14:42:07"),
            "fin"=> new Datetime( "2022-06-07 19:30:00")
        ),
        array(
            "debut" =>new Datetime("2022-06-06 14:30:00"),
            "fin" => new Datetime("2022-06-06 16:30:00"),
        ),
        array(
            "debut" =>new Datetime("2022-06-26 10:51:46"),
            "fin" =>new Datetime("2022-06-26 14:51:46"),
        ),
        array(
            "debut" => new Datetime("2022-06-03 09:45:55"),
            "fin" => new Datetime(" 2022-06-03 12:45:55"),
        ),
    );
    
    function is_conflit($dispo,$rdv){
        return ((  $rdv['fin'] > $dispo['debut'])&&(  $rdv['debut'] < $dispo['fin']));
    }
    
    function search_conflits($dispo_dates,$rdv){
        foreach($dispo_dates as $dispo){
            echo "test" ;
            var_dump($dispo); 
            echo "est-il en conflit avec ?" ;
            var_dump($rdv);
            echo "réponse: ";
            var_dump(is_conflit($dispo,$rdv));
             if(is_conflit($dispo,$rdv) ){
                 var_dump(is_conflit($dispo,$rdv));
                return $dispo;
            }
        }
                return  false;
            
    }
    
    $resul = search_conflits($dispo_dates, $rdvs[0]);
    var_dump($resul);
   var_dump(search_conflits($dispo_dates, $rdvs[0]));
   echo "test";


   // ttttttttttttttttttttttttttttttttttttttttttttttttttttt
   /* Online PHP Compiler (Interpreter) and Editor 
    return (($dispo['debut'] <$rdv['debut'] && $rdv['debut'] <$dispo['fin']) && ($rdv['fin'] < $dispo['fin'] && $rdv['fin']> $dispo['debut']));
   */
    $dispo_dates = array(
        array(
            "debut" => new Datetime("Friday 2022-06-03 08:30:00"),
            "fin" =>new  Datetime("Friday 2022-06-03 13:30:00"),
        ),
        array(
            "debut" =>new Datetime("Monday 2022-06-06 13:30:00"),
            "fin" =>new Datetime("Monday 2022-06-06 16:30:00"),
        ),
        array(
            "debut" =>new Datetime("Tuesday 2022-06-07 10:30:00"),  "fin" =>new Datetime("Tuesday 2022-06-07 13:30:00"),
        ),
        array(
            "debut" =>new Datetime("Tuesday 2022-06-07 15:30:00"),"fin" =>new Datetime("Tuesday 2022-06-07 19:30:00"),
        ),
    );
    $rdvs = array(
        array(
            "debut"=>new  Datetime("2022-06-07 13:42:00"),"fin"=> new Datetime( "2022-06-07 19:31:00")
        ),
         array(
            "debut"=>new  Datetime("2022-06-07 13:42:00"),"fin"=> new Datetime( "2022-06-07 16:31:00")
        ),
        array(
            "debut"=>new  Datetime("2022-06-07 13:42:00"),"fin"=> new Datetime( "2022-06-07 15:30:00")
        ),
         array(
            "debut"=>new  Datetime("2022-06-07 17:42:00"),"fin"=> new Datetime( "2022-06-07 20:31:00")
        ),
        array("debut" =>new Datetime("2022-06-06 13:30:00"),"fin" => new Datetime("2022-06-06 14:30:00"), ),
        
        array("debut" => new Datetime("2022-06-03 09:30:00"),"fin" => new Datetime(" 2022-06-03 10:30:00"), ),
        array( "debut" =>new Datetime("2022-06-03 11:30:00"), "fin" =>new Datetime("2022-06-03 12:30:00"),  ),
    );
    
    function is_conflits($dispo,$rdv){
        return ((  $rdv['fin'] > $dispo['debut'])&&(  $rdv['debut'] < $dispo['fin']));
    }
    
    function search_conflit($dispo_dates,$rdv){
        foreach($dispo_dates as $dispo){
             if(is_conflit($dispo,$rdv) ){
                return $dispo;
            }
        }
                return  false;
            
    }
   function split($dispo , $rdv){
        $disponible = [];
        if( $rdv['debut'] < $dispo['debut']&&$rdv['fin']>$dispo['fin'] ){
            echo"                                          cas 0
            -----";
             return $disponible;
        }else{
            if($rdv['debut']>=$dispo['debut'] &&$dispo['fin']>= $rdv['fin']){
                if($dispo['debut']<$rdv['debut']){
                    echo"                                          cas 1
                -----";
                     array_push($disponible,["debut"=>$dispo['debut'],"fin"=>$rdv['debut']]);
                     array_push($disponible,["debut"=>$rdv['fin'],"fin"=>$dispo['fin']]);
                }else{
                     echo"                                          cas 4
            -----";
                  array_push($disponible,["debut"=>$rdv['fin'],"fin"=>$dispo['fin'] ]);
                }
            }
            if($rdv['fin'] < $dispo['debut'] ||  $dispo['fin'] < $rdv['debut']){
                echo"                                          cas 2
            -----";
                    array_push($disponible,["debut"=>$dispo['debut'],"fin"=>$dispo['fin']]);
            }
            if($rdv['debut']  <= $dispo['fin']&& $dispo['fin']  < $rdv['fin'] ){
                echo"                                          cas 3
            -----";
                    array_push($disponible,["debut"=>$dispo['debut'],"fin"=>$rdv['debut']]);
            }
            if( $dispo['debut'] <= $rdv['fin'] && $rdv['fin']  < $dispo['fin']){
              if($dispo['debut']>$rdv['debut'])  {echo"                                          cas 4
            -----";
                  array_push($disponible,["debut"=>$rdv['fin'],"fin"=>$dispo['fin'] ]);}
            }
           
            return $disponible;
        }    
        
    }
    
    function filter($table){
        foreach($table as $tab){
            if($tab['debut']== $tab['fin'])
            unset($table[array_search($tab, $table)]);
        }
        return $table;
    }
    
    function mains($dispo_dates, $rdvs){
       //foreach($rdvs as $rdv){https://www.tutorialspoint.com/codingground.htm
       $t=[];
       $dispo = search_conflits($dispo_dates, $rdvs[6]);
            if($dispo!== false){
                $resul = split($dispo,$rdvs[6]);
                //var_dump($resul);
                unset($dispo_dates[array_search($dispo, $dispo_dates)]);
                $dispo_dates = array_merge( $dispo_dates,$resul);
            }else{
                echo"jhshbvsjqlhdvbqjlkhsvkjsvnklsbvqksgvb<kkcjlqjcbkws;hkjqsjvkhlq<kcjnkqjcsdjvhlskjfvmsdklhbmljvnbkdsjlkjvqlsjvnlwks";
            }
       //}
        return $dispo_dates;
    }
    $table = mains($dispo_dates, $rdvs);
   var_dump( filter($table));
   echo "test";
?>