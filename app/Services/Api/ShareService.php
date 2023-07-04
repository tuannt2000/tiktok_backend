<?php

namespace App\Services\Api;

use App\Contracts\Repositories\ShareRepositoryInterface;
use App\Contracts\Services\Api\ShareServiceInterface;
use App\Services\AbstractService;

class ShareService extends AbstractService implements ShareServiceInterface
{
    /**
     * @var ShareRepositoryInterface
     */
    protected $shareRepository;

    /**
     * ShareService constructor.
     * @param ShareRepositoryInterface $shareRepository
     */
    public function __construct(ShareRepositoryInterface $shareRepository)
    {
        $this->shareRepository = $shareRepository;
    }
}
