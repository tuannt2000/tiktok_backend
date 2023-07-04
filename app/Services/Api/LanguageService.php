<?php

namespace App\Services\Api;

use App\Contracts\Repositories\LanguageRepositoryInterface;
use App\Contracts\Services\Api\LanguageServiceInterface;
use App\Services\AbstractService;
use Illuminate\Support\Facades\Log;

class LanguageService extends AbstractService implements LanguageServiceInterface
{
    /**
     * @var LanguageRepositoryInterface
     */
    protected $languageRepository;

    /**
     * CategoryService constructor.
     * @param LanguageRepositoryInterface $languageRepository
     */
    public function __construct(LanguageRepositoryInterface $languageRepository)
    {
        $this->languageRepository = $languageRepository;
    }

    /**
     * @return array
     */
    public function index()
    {
        try {
            return [
                'code' => 200,
                'data' => $this->languageRepository->getAll()
            ];
        } catch (\Throwable $err) {
            Log::error($err);
            
            return [
                'code' => 400,
                'message' => $err,
            ];
        }
    }
}
