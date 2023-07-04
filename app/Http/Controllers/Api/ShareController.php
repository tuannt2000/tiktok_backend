<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Services\Api\ShareServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShareController extends Controller
{
    protected $shareService;

    public function __construct(ShareServiceInterface $shareService)
    {
        $this->shareService = $shareService;
    }
}
