<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ImportationsDouane
 * 
 * @property string|null $ANNEE
 * @property string|null $BUREAU
 * @property string|null $NUMERO
 * @property string|null $ARTICLE
 * @property string|null $LIEU_EMBARQUEMENT
 * @property string|null $NAVIRE
 * @property string|null $TYPE_NAVIRE
 * @property string|null $PAYS_DESTINATION
 * @property string|null $VILLE_DESTINATION
 * @property string|null $DATE_EMBARQUEMENT
 * @property string|null $DATE_ARRIVEE
 * @property string|null $CONNAISSEMENT
 * @property string|null $NBRE_CONTENEUR
 * @property string|null $EXPEDITEUR
 * @property string|null $NOM_DEST
 * @property string|null $NOM_VOIE_DEST
 * @property string|null $VILLE_DEST
 * @property string|null $CONSIGNATAIRE
 * @property string|null $MARCHANDISE
 * @property string|null $PAYS_PROVENANCE
 * @property string|null $POIDS
 * @property string|null $VOLUME
 * @property string|null $NBRE_COLIS
 * @property string|null $MODE_CONDITIONNEMENT
 * @property string|null $NUMERO_CONTENEUR
 * @property string|null $TYPE_CONTENEUR
 * @property string|null $TAILLE_CONTENEUR
 *
 * @package App\Models
 */
class ImportationsDouane extends Model
{
	protected $table = 'importations_douanes';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'ANNEE',
		'BUREAU',
		'NUMERO',
		'ARTICLE',
		'LIEU_EMBARQUEMENT',
		'NAVIRE',
		'TYPE_NAVIRE',
		'PAYS_DESTINATION',
		'VILLE_DESTINATION',
		'DATE_EMBARQUEMENT',
		'DATE_ARRIVEE',
		'CONNAISSEMENT',
		'NBRE_CONTENEUR',
		'EXPEDITEUR',
		'NOM_DEST',
		'NOM_VOIE_DEST',
		'VILLE_DEST',
		'CONSIGNATAIRE',
		'MARCHANDISE',
		'PAYS_PROVENANCE',
		'POIDS',
		'VOLUME',
		'NBRE_COLIS',
		'MODE_CONDITIONNEMENT',
		'NUMERO_CONTENEUR',
		'TYPE_CONTENEUR',
		'TAILLE_CONTENEUR'
	];
}
