<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ImportationsDouane;
use App\Models\ImportationsBSC;

use Illuminate\Support\Facades\DB;

class ImportationsController extends Controller
{
    /**
     * Retourne poids marchandises douanes
     *
     * @return \Illuminate\Http\Response
     */
    public function getPoidsDouanes(Request $request)
    {

        return $this->getQuery($request, "importations_douanes", "poids");
    }

    /**
     * retourn l'insight le nombre conteneur   | douanes  *
     * @return \Illuminate\Http\Response
     */
    public function getNombreConteneurDouanes(Request $request)
    {
        return $this->getQuery($request, "importations_douanes", "conteneur");

    }

    /**
     * Retourne les temps de voyage des marchandises | donnees Douanes
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getTravelTimeDouane(Request $request)
    {

            return DB::table('importations_douanes')
                ->selectRaw('marchandise, datediff(date_arrivee, date_embarquement) as temps_voyage')
                // ->whereRaw('datediff(created_at, now()) > ?', [-99])
                ->get();

    }

    /**
     * Retourne poids marchandises BSC
     *
     * @return \Illuminate\Http\Response
     */
    public function getPoidsBSC(Request $request)
    {

        return $this->getQuery($request, "importations_bscs", "tonnage");
    }

    /**
     * retourn l'insight le nombre conteneur   | BSC  *
     * @return \Illuminate\Http\Response
     */
    public function getNombreConteneurBSC(Request $request)
    {
        return $this->getQuery($request, "importations_bscs", "conteneur");

    }

    public function getNombreVehiculeBSC(Request $request){
        $nombreTonne = $request->input("nombre_tonne");
        return DB::table("importations_bscs")
                    ->where("type_conditionnement", "like", "%vehicule%")
                    ->where("type_conditionnement", "like", "%".$nombreTonne."%")
                    ->count("type_conditionnement");
    }

    private function getQuery(Request $request, $table, $insight)
    {
        $importations = DB::table($table);
        /*On filtre le tonnage des marchandisses importés dans un interavlles de temps précisé par l'utilisateur
            //Si l'utilisateur ne précise pas de dates, on considère l'intervalle de temps maximal (date la plus ancienne
            // à date la plus récente)
        */
        $dates = $request->input("dates");
        $dates = explode(";", $dates);
        if($dates[0] !== "null" && $dates[1] !== "null"){
            $importations = $importations->where("date_arrivee", ">=", $dates[0]);
            $importations = $importations->where("date_arrivee", "<=", $dates[1]);
        }
        else {
            return ["Précisez un intervalle de temps"];
        }
        $filtres = $request->all();
        // Si on a que le fitre dates (tjrs présent), on retourne le tonnage des marchandise importées durant
        // l'intervalle de temps indiqué
        if(count($filtres) == 1 && $insight == "poids"){
            return [
                ["poids des marchandise importes" => ""],
                ["poids" => $importations->sum("poids")]
            ];
        }else if(count($filtres) == 1 && $insight == "tonnage"){
            return [
                ["poids des marchandise importes" => ""],
                ["poids" => $importations->sum("tonnage")]
            ];
        }else if(count($filtres) == 1 && $insight == "fret"){
            return [
                ["le fret moyen" => "nn"],
                ["moyenne du fret" => $importations->avg("fret")]
            ];
        }else if(count($filtres) == 1 && $insight == "conteneur" && $table == "importations_douanes"){
            return [
                ["nombre de conteneur importés" => "nn"],
                ["nombre de conteneur" => $importations->count("nbre_conteneur")]
            ];
        }else if(count($filtres) == 1 && $insight == "conteneur" && $table == "importations_bscs"){
            return [
                ["nombre de conteneur importés" => "nn"],
                ["nombre de conteneur" => $importations->count("quantite_conditionnement")]
            ];
        }

        $groupBy = []; // tableau de colonnnes sur lesquelles on va grouper la somme du tonnage des marchandises
        /*
            Filtre généraliste qui considère toutes les valeurs du filtre Level1
            Le filtre level1 concerne le regroupement du tonnage par certaines colonnes  : Exemple regroupe le tonnage
            par  consignataires, pays_origine, ville_destination,  etc
        */

        if(array_key_exists("level1", $filtres)){
            $level1Filters = $request->input("level1");
            $tabLevel1Filters = explode(";", $level1Filters);
            $groupBy = $tabLevel1Filters;
            if($insight == "poids" ){
                $tabLevel1Filters[] = DB::raw("SUM(poids) AS poids");
            }else if($insight == "tonnage"){
                $tabLevel1Filters[] = DB::raw("SUM(tonnage) AS poids");
            }else if($insight == "fret"){
                $tabLevel1Filters[] = DB::raw("AVG(fret) AS 'moyenne du fret'");
            }else if($insight == "conteneur" && $table == "importations_douanes"){
                $tabLevel1Filters[] = DB::raw("count(nbre_conteneur) AS 'nombre de conteneur'");
            }else if($insight == "conteneur" && $table == "importations_bscs"){
                $tabLevel1Filters[] = DB::raw("count(quantite_conditionnement) AS 'nombre de conteneur'");
            }
            $importations = $importations->select($tabLevel1Filters);
        }

        // On ajoute des filtres plus spécifiques: Par exemple on ne veut que le tonnage du consignataire M.S.C SENEGAL
        // ou que des tonnages ou la ville de destination est dakar, etc
        foreach ($filtres as $key => $filtre) {
            if($key !== "dates" && $key !== "level1"){
                    $importations->where($key, "like", "%.$filtre.%");
            }

        }
        // On définit le groupe du tonnage des marchandises avec le filtre de niveau 1 (level1)
        if($groupBy){
            $importations->groupBy($groupBy);
        }
        return $importations->get();

    }

}
