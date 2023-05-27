<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'city',
        'city_ascii',
        'latitude',
        'longitude',
        'country'
    ];


    public static function findCityByName($name)
    {
        return City::firstWhere('city',$name);
    }

    /**
     * Check if User provided city along with coutry exists in database or not
     *
     * @param  string  $city
     * @param  string  $country
     * @return int
     */
    public static function checkIfEmailExists(String $city, String $country)
    {
        return City::where(['city' => $city, 'country' => $country])->count();
    }
}
