<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DouaneFiltre
 * 
 * @property string|null $filtre_douanes
 *
 * @package App\Models
 */
class DouaneFiltre extends Model
{
	protected $table = 'douane_filtres';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'filtre_douanes'
	];
}
