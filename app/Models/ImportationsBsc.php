<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ImportationsBsc
 * 
 * @property int|null $code_sh
 * @property string|null $libelle_marchandise
 * @property string|null $pays_origine
 * @property int|null $quantite
 * @property string|null $emballage
 * @property string|null $description_marchandise
 * @property string|null $type_conteneur
 * @property string|null $type_conditionnement
 * @property int|null $quantite_conditionnement
 * @property int|null $volume
 * @property int|null $tonnage
 * @property int|null $numero_bsc
 * @property string|null $nom_chargeur
 * @property string|null $consignataire
 * @property string|null $destinataire
 * @property string|null $numero_connaissement
 * @property Carbon|null $date_connaisement
 * @property string|null $lieu_livraison
 * @property Carbon|null $date_reglement
 * @property string|null $place_emission
 * @property Carbon|null $date_emission
 * @property Carbon|null $date_depart_navire
 * @property string|null $nom_navire
 * @property int|null $fret
 * @property string|null $port_origine
 * @property int|null $montantttcstat
 * @property string|null $code_devise
 * @property int|null $taux_devise
 *
 * @package App\Models
 */
class ImportationsBsc extends Model
{
	protected $table = 'importations_bscs';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'code_sh' => 'int',
		'quantite' => 'int',
		'quantite_conditionnement' => 'int',
		'volume' => 'int',
		'tonnage' => 'int',
		'numero_bsc' => 'int',
		'fret' => 'int',
		'montantttcstat' => 'int',
		'taux_devise' => 'int'
	];

	protected $dates = [
		'date_connaisement',
		'date_reglement',
		'date_emission',
		'date_depart_navire'
	];

	protected $fillable = [
		'code_sh',
		'libelle_marchandise',
		'pays_origine',
		'quantite',
		'emballage',
		'description_marchandise',
		'type_conteneur',
		'type_conditionnement',
		'quantite_conditionnement',
		'volume',
		'tonnage',
		'numero_bsc',
		'nom_chargeur',
		'consignataire',
		'destinataire',
		'numero_connaissement',
		'date_connaisement',
		'lieu_livraison',
		'date_reglement',
		'place_emission',
		'date_emission',
		'date_depart_navire',
		'nom_navire',
		'fret',
		'port_origine',
		'montantttcstat',
		'code_devise',
		'taux_devise'
	];
}
