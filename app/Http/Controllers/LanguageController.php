<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;


class LanguageController extends Controller
{
	
	public function store($lang) : RedirectResponse{

		if($this->isAvailable($lang)){
			App::setLocale($lang);

			Session::put('locale', $lang);

			return redirect()->back();
		}

		return redirect()->back()->withError(['lang' => __('lang.unavailable', ['lang' => $lang])]);
	}

	public function allAvailable() : JsonResponse {

		return response()->json([
			'datas' => $this->getAvailableLang(),
			'errors' => [],
		]);
	}

	public function show($lang = null) : JsonResponse {

		$lang = $lang ?? App::currentLocale(); 

		if($this->isAvailable($lang)){
	
			$translations = Cache::remember("translations_$lang", 2/* 3600 */, function () use ($lang) {
				return LanguageController::getLangDatas($lang);
			});

			return response()->json([
				'datas' => $translations,
				'lang' => $lang,
				'errors' => [],
			]);
		}

		return response()->json([
			'datas' => [],
			'lang' => $lang,
			'errors' => ['message' => __('lang.unavailable', ['lang' => $lang])],
		]);
	}

	protected function isAvailable($lang) : bool {
		return !empty($this->getAvailableLang($lang));
	}

	protected function getAvailableLang(string $key = null) : array|null {
		$available_langs = config('app.available_language', [
			'en' => [
				'iso' => 'en_US',
				'name' => 'English',
				'country' => 'USA',
				'rtl' => false,
			],
		]);

		return  $key ? (isset($available_langs[$key]) ? $available_langs[$key] : null) : $available_langs;
	}

	protected static function getLangDatas(string $locale) : array{
		$langDir = lang_path($locale);

		$langData = [];

		if(is_dir($langDir)){
			foreach (File::files($langDir) as $file) {
				$filename = $file->getFilenameWithoutExtension();
				$fileData = include $file->getPathname();
				$langData[$filename] = $fileData;
			}
		}
		return $langData;
	}
}
