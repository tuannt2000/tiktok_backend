<?php

namespace App\Http\Controllers;

abstract class AbstractController extends Controller
{
    protected $user;
    protected $compacts;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = $request->user();

            return $next($request);
        });
    }
}
