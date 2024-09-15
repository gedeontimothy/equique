<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class UserManagerController extends Controller
{
	public function dashboard(){
		return Inertia::render('pages/manager/Dashboard');
	}
}
