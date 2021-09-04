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
                ->selectRaw('navire, datediff(date_arrivee, date_embarquement) as temps_voyage')
                ->orderBy('date_arrivee', 'desc')
                 ->limit(15)
                // ->where("date_arrivee", "<=", "2021-04-16")
                // ->where("date_arrivee", ">=", "2021-03-08")
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

    /**
     * retourn l'insight le nombre conteneur   | BSC  *
     * @return \Illuminate\Http\Response
     */
    public function getFretBSC(Request $request)
    {
        return $this->getQuery($request, "importations_bscs", "fret");

    }

    public function getNombreVehiculeBSC(Request $request){
        return $this->getQuery($request, "importations_bscs", "vehicule");
        // $nombreTonne = $request->input("nombre_tonne");
        // $vehicules = DB::table("importations_bscs")
        //             ->where("poids_vehicule", "<=", $nombreTonne)
        //             ;

        // $dates = $request->input("dates");
        // $dates = explode(";", $dates);
        // if($dates[0] !== "null" && $dates[1] !== "null"){
        //     $vehicules = $vehicules->where("date_depart_navire", ">=", $dates[0]);
        //     $vehicules = $vehicules->where("date_depart_navire", "<=", $dates[1]);
        // }
        // return [
        //     ["vehicule" => $vehicules->count("type_conditionnement")]
        // ];
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
        if($dates[0] !== "null" && $dates[1] !== "null" && $table == "importations_douanes"){
            $importations = $importations->where("date_arrivee", ">=", $dates[0]);
            $importations = $importations->where("date_arrivee", "<=", $dates[1]);

        }else if($dates[0] !== "null" && $dates[1] !== "null" && $table == "importations_bscs"){
            $importations = $importations->where("date_depart_navire", ">=", $dates[0]);
            $importations = $importations->where("date_depart_navire", "<=", $dates[1]);
        }
        else {
            return ["Précisez un intervalle de temps"];
        }
        $filtres = $request->all();
        // Si on a que le fitre dates (tjrs présent) (dans ce cas le tableau $filtre ne contient
        // qu'un seul élément), on retourne le tonnage des marchandise importées durant
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
                ["le fret moyen" => ""],
                ["moyenne du fret" => $importations->avg("fret")]
            ];
        }else if(count($filtres) == 2 && $insight == "vehicule"){
            $nombreTonne = $request->input("nombre_tonne");
            return [
                ["vehicule" => $importations->where("poids_vehicule", "<=", $nombreTonne)->count("type_conditionnement")]
            ];
        }else if(count($filtres) == 2 && $insight == "conteneur" && $table == "importations_douanes" && array_key_exists("taille_conteneur", $filtres) ){

            $tailleConteneur = $request->input("taille_conteneur");

            return [
                ["nombre de conteneur importés" => "nn"],
                ["nombre de conteneur" => $importations->where("taille_conteneur", "=", $tailleConteneur)->sum("nbre_conteneur")]
            ];


        }else if(count($filtres) == 2 && $insight == "conteneur" && $table == "importations_bscs" && array_key_exists("type_conditionnement", $filtres)){

            $typeConditionnement = $request->input("type_conditionnement");
            return [
                ["nombre de conteneur importés" => "nn"],
                ["nombre de conteneur" => $importations->where("type_conditionnement", "like", "%$typeConditionnement PIEDS%")->sum("quantite_conditionnement")]
            ];
        }

        $groupBy = []; // tableau de colonnnes sur lesquelles on va grouper la somme du tonnage des marchandises
        /*
            Filtre généraliste qui considère toutes les valeurs du filtre Level1
            Le filtre level1 concerne le regroupement des indicateurs par certaines colonnes  : Exemple regroupe le tonnage, le nbre de conteneur, le fret etc
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
            }else if($insight == "vehicule"){
                $tabLevel1Filters[] = DB::raw("COUNT(fret) AS 'type_conditionnement'");
            }else if($insight == "conteneur" && $table == "importations_douanes"){
                $tailleConteneur = $request->input("taille_conteneur");
                if($tailleConteneur == "20"){
                    // return 20;
                    $tabLevel1Filters[] = DB::raw("SUM(nbre_vingt_pieds) AS 'nombre de conteneur'");
                }else if($tailleConteneur == "40"){
                    $tabLevel1Filters[] = DB::raw("SUM(nbre_quarante_pieds) AS 'nombre de conteneur'");
                }if($tailleConteneur == "45"){
                    $tabLevel1Filters[] = DB::raw("SUM(nbre_quarante_cinq_pieds) AS 'nombre de conteneur'");
                }

            }else if($insight == "conteneur" && $table == "importations_bscs"){
                $tailleConteneur = $request->input("type_conditionnement");
                if($tailleConteneur == "20"){
                    // return 20;
                    $tabLevel1Filters[] = DB::raw("SUM(nbre_vingt_pieds) AS 'nombre de conteneur'");
                }else if($tailleConteneur == "40"){
                    $tabLevel1Filters[] = DB::raw("SUM(nbre_quarante_pieds) AS 'nombre de conteneur'");
                }if($tailleConteneur == "45"){
                    $tabLevel1Filters[] = DB::raw("SUM(nbre_quarante_cinq_pieds) AS 'nombre de conteneur'");
                }

                // $tabLevel1Filters[] = DB::raw("SUM(quantite_conditionnement) AS 'nombre de conteneur'");
            }

            $importations = $importations->select($tabLevel1Filters);
        }

        // On ajoute des filtres plus spécifiques: Par exemple on ne veut que le tonnage du consignataire M.S.C SENEGAL
        // ou que des tonnages où la ville de destination est dakar, etc
        if($insight == "vehicule"){
            $nombreTonne = $request->input("nombre_tonne");
            $importations->where("poids_vehicule", "<=", $nombreTonne);

        }
        foreach ($filtres as $key => $filtre) {
            if($key !== "dates" && $key !== "level1" && $key !== "taille_conteneur" && $key !== "type_conditionnement" && $key !== "nombre_tonne"){

                     $importations->where($key, "like", "%$filtre%");


            }

        }


        // On définit le groupe du tonnage des marchandises avec le filtre de niveau 1 (level1)
        if($groupBy){
            $importations->groupBy($groupBy);
        }
        return $importations->get();

    }

}
