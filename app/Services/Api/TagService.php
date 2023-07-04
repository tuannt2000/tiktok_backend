<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 7/8/2022
 * Time: 3:34 PM
 */

namespace App\Services\Api;

use App\Contracts\Services\Api\TagServiceInterface;
use App\Contracts\Repositories\TagRepositoryInterface;
use App\Services\AbstractService;
use Illuminate\Support\Facades\Log;

class TagService extends AbstractService implements TagServiceInterface
{
    /**
     * @var TagRepositoryInterface
     */
    protected $tagRepository;

    /**
     * TagService constructor.
     * @param TagRepositoryInterface $tagRepository
     */
    public function __construct(TagRepositoryInterface $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    /**
     * @return array
     */
    public function index()
    {
        try {
            return [
                'code' => 200,
                'data' => $this->tagRepository->getAll()
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