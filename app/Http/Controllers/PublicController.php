<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class PublicController extends Controller
{
	public function welcome() {
		return Inertia::render('pages/public/Welcome');
	}

	public function home() {
		return Inertia::render('pages/public/Home');
	}
}
