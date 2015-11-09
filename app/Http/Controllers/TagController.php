<?php namespace App\Http\Controllers;

use App\Service;
use App\Country;
use App\Destination;
use App\Provider;
use App\CategoryService;


class TagController extends Controller {


	public function getTags()
	{
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

		return response()->json($arrResult);
	}

}
