<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PostController extends Controller
{

	public function store()
	{

		$this->refreshToken();

		$response = Http::withHeaders([

			"Accept" => "application/json",
			"Authorization" => "Bearer " . auth()->user()->token->access_token

		])->post("http://integrar.pro/api/posts", [

			"title" => "test last",
			"url" => "test-last",
			"resume" => "test",
			"content" => "test",
			"category_id" => 1

		]);

		return $response->json();

	}

}