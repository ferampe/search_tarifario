<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Service;
use App\Country;
use App\Destination;
use App\Provider;
use App\CategoryService;

class SearchController extends Controller {

	public function form(){
		return view('search');
	}

	public function search(Request $request)
	{

		\DB::enableQueryLog();


		echo "<strong>String query en crudo: </strong>";
		var_dump($request->input('tags'));
		echo "<hr/>";

		$arrQuery = explode(';', $request->input('tags'));

		echo "<strong>String Array query en crudo: </strong>";
		var_dump($arrQuery);
		echo "<hr/>";

		$arrQuery = array_map(function($item){
			return strtolower(trim($item));
		}, $arrQuery);

		echo "<strong>Array query en saneado sin espacios en blanco: </strong>";
		var_dump($arrQuery);
		echo "<hr/>";

		$arrCountries = Country::lists('name', 'id');
		$arrCountries = array_map(function($item){
			return strtolower(trim($item));
		}, $arrCountries);

		$arrDestinations = Destination::lists('name', 'id');
		$arrDestinations = array_map(function($item){
			return strtolower(trim($item));
		}, $arrDestinations);

		$arrProviders = Provider::lists('name', 'id');
		$arrProviders = array_map(function($item){
			return strtolower(trim($item));
		}, $arrProviders);

		$arrCategoryService = CategoryService::lists('name', 'id');
		$arrCategoryService = array_map(function($item){
			return strtolower(trim($item));
		}, $arrCategoryService);


		echo "<strong>Source Country: </strong>";
		var_dump($arrCountries);
		echo "<hr/>";

		echo "<strong>Source Destination: </strong>";
		var_dump($arrDestinations);
		echo "<hr/>";

		echo "<strong>Source Provider: </strong>";
		var_dump($arrProviders);
		echo "<hr/>";

		echo "<strong>Source Category Service: </strong>";
		var_dump($arrCategoryService);
		echo "<hr/>";

	

		$countries = array_keys(array_intersect($arrCountries, $arrQuery));
		$destinations = array_keys(array_intersect($arrDestinations, $arrQuery));
		$providers = array_keys(array_intersect($arrProviders, $arrQuery));
		$categoriesServices = array_keys(array_intersect($arrCategoryService, $arrQuery));

		

		echo "<strong>Resultado array_intersec de Country solo indice: </strong>";
		var_dump($countries);
		echo "<hr/>";
		echo "<strong>Resultado array_intersec de Destinations solo indice: </strong>";
		var_dump($destinations);
		echo "<hr/>";
		echo "<strong>Resultado array_intersec de Providers solo indice: </strong>";
		var_dump($providers);
		echo "<hr/>";
		echo "<strong>Resultado array_intersec de CAtegory Services solo indice: </strong>";
		var_dump($categoriesServices);
		echo "<hr/>";


		
		/* QUERY BUILD */
		$services = Service::on();
		if(!empty($countries)){
			$services = $services->whereIn('country_id', $countries);
		}

		if(!empty($destinations)){
			$services = $services->whereIn('destination_id', $destinations);
		}

		if(!empty($providers)){
			$services = $services->whereIn('provider_id', $providers);
		}

		if(!empty($categoriesServices)){
			$services = $services->whereIn('provider_id', $categoriesServices);
		}

		$services = $services->get();
	
		echo "<strong>consultas Generadas en la BD: </strong>";
		var_dump(\DB::getQueryLog());
		echo "<hr/>";
		

		echo "<h2>Resultado</h2>";

		foreach ($services as $service) {
			echo $service->name."<br/>";
		}
		

	}

	public function getItem(Request $request){

	
		$service = Service::on()->join('countries', 'services.country_id', '=', 'countries.id')->join('destinations', 'destinations.id', '=', 'services.destination_id')->join('categories_services', 'services.category_service_id', '=', 'categories_services.id')->join('providers', 'services.provider_id', '=', 'providers.id')->where('services.id', '=', $request->input('id'));


		$service = $service->orderBy('countries.name', 'ASC')->orderBy('destinations.name', 'ASC')->orderBy('categories_services.name', 'ASC')->orderBy('providers.name', 'ASC')->orderBy('services.name', 'ASC')->first(['services.id','countries.name as name_country', 'destinations.name as name_destination', 'categories_services.name as name_category', 'providers.name as name_provider', 'services.name as name_service']);

		return view('parts.item', ['service' => $service])->render();
	}

	public function getResult(Request $request){

		//dd($request->input('tags'));

		\DB::enableQueryLog();

		$arrQuery = explode(';', $request->input('tags'));

		$arrQuery = array_map(function($item){
			return strtolower(trim($item));
		}, $arrQuery);

		$arrCountries = Country::lists('name', 'id');
		$arrCountries = array_map(function($item){
			return strtolower(trim($item));
		}, $arrCountries);

		$arrDestinations = Destination::lists('name', 'id');
		$arrDestinations = array_map(function($item){
			return strtolower(trim($item));
		}, $arrDestinations);

		$arrProviders = Provider::lists('name', 'id');
		$arrProviders = array_map(function($item){
			return strtolower(trim($item));
		}, $arrProviders);

		$arrCategoryService = CategoryService::lists('name', 'id');
		$arrCategoryService = array_map(function($item){
			return strtolower(trim($item));
		}, $arrCategoryService);


		$countries = array_keys(array_intersect($arrCountries, $arrQuery));
		$destinations = array_keys(array_intersect($arrDestinations, $arrQuery));
		$providers = array_keys(array_intersect($arrProviders, $arrQuery));
		$categoriesServices = array_keys(array_intersect($arrCategoryService, $arrQuery));


		
		/* QUERY BUILD */
		$services = Service::on()->join('countries', 'services.country_id', '=', 'countries.id')->join('destinations', 'destinations.id', '=', 'services.destination_id')->join('categories_services', 'services.category_service_id', '=', 'categories_services.id')->join('providers', 'services.provider_id', '=', 'providers.id');


		if(!empty($countries)){
			$services = $services->whereIn('services.country_id', $countries);
		}

		if(!empty($destinations)){	
			$services = $services->whereIn('services.destination_id', $destinations);		
		}

		if(!empty($providers)){
			$services = $services->whereIn('services.provider_id', $providers);
		}

		if(!empty($categoriesServices)){
			$services = $services->whereIn('services.category_service_id', $categoriesServices);
		}

		$services = $services->orderBy('countries.name', 'ASC')->orderBy('destinations.name', 'ASC')->orderBy('categories_services.name', 'ASC')->orderBy('providers.name', 'ASC')->orderBy('services.name', 'ASC')->get(['services.id','countries.name as name_country', 'destinations.name as name_destination', 'categories_services.name as name_category', 'providers.name as name_provider', 'services.name as name_service']);

		return view('parts.result_services', ['services' => $services])->render();
	}

	public function getArrSearch(){

		$arrResult = [];
		$arrCountries = Country::lists('name');
		$arrDestinations = Destination::lists('name');
		$arrProviders = Provider::lists('name');
		$arrCategoryService = CategoryService::lists('name');

		
		foreach ($arrCountries as $item) {
			$arrResult[] = strtolower(trim($item));
		}

		
		foreach ($arrDestinations as $item) {
			$arrResult[] = strtolower(trim($item));
		}


		foreach ($arrProviders as $item) {
			$arrResult[] = strtolower(trim($item));
		}


		foreach ($arrCategoryService as $item) {
			$arrResult[] = strtolower(trim($item));
		}


		//dd($arrResult);
		//$arrResult = array_unique(array_merge($arrCountries, $arrDestinations, $arrProviders, $arrCategoryService));

		return response()->json($arrResult);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return "Hola souy un Auto";
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
