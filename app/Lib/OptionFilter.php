<?php

namespace App\Lib;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder;

abstract class OptionFilter
{

	/**
	 * [Description for date]
	 *
	 * @param mixed                                                                    $datas
	 * @param \Illuminate\Database\Eloquent\Builder|Illuminate\Database\Query\Builder  $query
	 * @param array                                                                    $options
	 * 
	 * @return bool
	 * 
	 */
	public static function date($datas, EloquentBuilder|Builder $query, array $options) : bool {

		$query->where(function($q) use ($datas, $options){

			switch ($datas) {
	
				case 'between':
	
					if(isset($options['date-start-at']) && isset($options['date-end-at'])){
	
						$q->where('bought_at', '>=', $options['date-start-at']);
	
						$q->where('bought_at', '<=', $options['date-end-at']);
	
					}
	
					break;
	
				case 'start-at':
	
					if(isset($options['date-start-at']))
						$q->where('bought_at', '>=', $options['date-start-at']);
	
					break;
	
				case 'end-at':
	
					if(isset($options['date-start-at']))
						$q->where('bought_at', '<=', $options['date-end-at']);
	
					break;
	
				case 'today':
	
					$q->where('bought_at', '>=', now()->format('Y-m-d 00:00:00'));
	
					break;
	
				case 'since-yesterday':
	
					$q->where('bought_at', '>=', now()->add('-1 day')->format('Y-m-d 00:00:00'));
	
					break;
	
				case 'since-before-yesterday':
	
					$q->where('bought_at', '>=', now()->add('-2 days')->format('Y-m-d 00:00:00'));
	
					break;
	
				case 'since-week':
	
					$q->where('bought_at', '>=', now()->add('-1 week')->format('Y-m-d 00:00:00'));
	
					break;
	
				case 'since-month':
	
					$q->where('bought_at', '>=', now()->add('-1 month')->format('Y-m-d 00:00:00'));
	
					break;
	
				case 'since-three-months':
	
					$q->where('bought_at', '>=', now()->add('-3 months')->format('Y-m-d 00:00:00'));
	
					break;
	
				case 'since-six-month':
	
					$q->where('bought_at', '>=', now()->add('-6 months')->format('Y-m-d 00:00:00'));
	
					break;
	
				case 'since-begining-year':
	
					$q->where('bought_at', '>=', now()->format('Y-01-01 00:00:00'));
	
					break;
	
				case 'since-year':
	
					$q->where('bought_at', '>=', now()->add('-1 year')->format('Y-01-01 00:00:00'));
	
					break;
	
				default:
	
					$q->where('bought_at', $datas);
	
					break;
	
			}

		});

		return true;

	}

	/**
	 * [Description for status]
	 *
	 * @param mixed                                                                    $datas
	 * @param \Illuminate\Database\Eloquent\Builder|Illuminate\Database\Query\Builder  $query
	 * @param array                                                                    $options
	 * 
	 * @return bool
	 * 
	 */
	public static function status($datas, EloquentBuilder|Builder $query, array $options) : bool {

		$datas = is_array($datas) ? $datas : explode(',', $datas);

		$query->where(
			function($q) use($datas) {
				$q->whereIn('status', $datas);
			}
		);

		return true;

	}
	

	/**
	 * [Description for sort]
	 *
	 * @param mixed                                                                    $datas
	 * @param \Illuminate\Database\Eloquent\Builder|Illuminate\Database\Query\Builder  $query
	 * @param array                                                                    $options
	 * 
	 * @return bool
	 * 
	 */
	public static function sort($datas, EloquentBuilder|Builder $query, array $options) : bool {

		$datas = is_array($datas) ? $datas : (is_string($datas) ? explode(',', $datas) : null);

		if(is_array($datas)){

			foreach ($datas as $sortType) {

				$type = trim(trim($sortType), '-');

				$direction = preg_match('/^\-.*/', $sortType) ? 'desc' : 'asc';

				switch ($type) {
					case 'updated_at':
						$query->orderBy('updated_at', $direction);
						break;
					case 'created_at':
						$query->orderBy('created_at', $direction);
						break;
					case 'bought_at':
						$query->orderBy('bought_at', $direction);
						break;
					case 'status':
						$query->orderBy('status', $direction);
						break;
				}

			}

			return true;

		}

		return false;

	}

}
