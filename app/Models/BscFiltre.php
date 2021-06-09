<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BscFiltre
 * 
 * @property string|null $filtre_bsc
 *
 * @package App\Models
 */
class BscFiltre extends Model
{
	protected $table = 'bsc_filtres';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'filtre_bsc'
	];
}
