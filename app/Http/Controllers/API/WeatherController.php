<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\CityCollection;

use App\Models\City;
use Carbon\Carbon;
use Weather;


class WeatherController extends BaseController
{
    /**
     * @var City
     */
    protected $cityModel;
    
    public function __construct(City $cityModel)
    {
        $this->city_model = $cityModel;
        $this->weatherapp = new Weather();
    }

    /**
     * Get Company Details of Logged in Company Admin
     *
     * @param  Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllAvailableCities(Request $request)
    {
        $cities = $this->city_model::select('id','city','country')->simplePaginate(10);
        $result = [
            'cities' => CityCollection::collection($cities),
            'next_page' => $cities->hasMorePages()
        ];
        return $this->sendResponse($result,'City list fetched successfully');   
    }

    /**
     * Add New City To database
     *
     * @param  Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addNewCity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'city' => 'required',
            'country' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), $validator->errors()->first(), 400);
        }
        if ($this->city_model::checkIfEmailExists($request->city,$request->country) > 0) {
            return $this->sendError('City Already exists', [], 400);   
        }
        $city = new $this->city_model();
        $city->city = $request->city;
        $city->country = $request->country;
        if ($request->has('city_ascii')) {
            $city->city_ascii = $request->city_ascii;
        }
        if ($request->has('latitude')) {
            $city->latitude = $request->latitude;
        }
        if ($request->has('longitude')) {
            $city->longitude = $request->longitude;
        }
        if ($city->save()) {
            $result = new CityCollection($city);
            return $this->sendResponse($result,'City added successfully');   
        }
        return $this->sendError('Something went wrong', '', 400);     

        $cities = $this->city_model::select('id','city','country')->simplePaginate(10);
    }

    /**
     * Get Current Weather forecast for a city
     *
     * @param  Illuminate\Http\Request $request
     * @param  String $city
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCurrentWeatherByCity(Request $request,String $city="")
    {
        $cityCheck = $this->city_model::findCityByName($city);
        if (!$cityCheck) {
            return $this->sendError('Invalid City Name', [], 400);    
        }
        try {
            $current = $this->weatherapp->getCurrentByCity($cityCheck->city);
            $result = [
                'current' => $current
            ];
            return $this->sendResponse($result,'Cities current weather report fetched successfully');   
        } catch (\RakibDevs\Weather\Exceptions\WeatherException $e) {
            return $this->sendError($e->getMessage(), [], 400);    
        }
    }

    /**
     * Get Previous 5 Weather forecast for a city
     *
     * @param  Illuminate\Http\Request $request
     * @param  String $city
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPreviousWeatherByCity(Request $request,String $city="")
    {
        $cityCheck = $this->city_model::findCityByName($city);
        if (!$cityCheck) {
            return $this->sendError('Invalid City Name', [], 400);    
        }
        try {
            $current = $this->weatherapp->getHistoryByCord($cityCheck->latitude,$cityCheck->longitude,Carbon::now()->subDays(5)->format('Y-m-d'));
            $result = [
                'current' => $current
            ];
            return $this->sendResponse($result,'Cities weather history report fetched successfully');   
        } catch (\RakibDevs\Weather\Exceptions\WeatherException $e) {
            return $this->sendError($e->getMessage(), [], 400);    
        }
    }

    /**
     * Get Next 4 days Weather forecast for a city
     *
     * @param  Illuminate\Http\Request $request
     * @param  String $city
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFutureWeatherByCity(Request $request,String $city="")
    {
        $cityCheck = $this->city_model::findCityByName($city);
        if (!$cityCheck) {
            return $this->sendError('Invalid City Name', [], 400);    
        }
        try {
            $current = $this->weatherapp->get3HourlyByCity($cityCheck->city);
            $result = [
                'current' => $current
            ];
            return $this->sendResponse($result,'Cities future weather report fetched successfully');   
        } catch (\RakibDevs\Weather\Exceptions\WeatherException $e) {
            return $this->sendError($e->getMessage(), [], 400);    
        }
    }
}
