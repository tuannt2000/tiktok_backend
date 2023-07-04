<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Contracts\Services\Api\LanguageServiceInterface;

class LanguageController extends Controller
{
    protected $languageService;

    public function __construct(LanguageServiceInterface $languageService)
    {
        $this->languageService = $languageService;
    }

    public function index () {
        $result = $this->languageService->index();

        return response()->json($result, 200);
    }
}
