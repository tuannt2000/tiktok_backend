<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 7/6/2022
 * Time: 3:20 PM
 */

namespace App\Services\Admin;

use App\Contracts\Repositories\VideoRepositoryInterface;
use App\Contracts\Services\Admin\VideoServiceInterface;
use App\Services\AbstractService;

class VideoService extends AbstractService implements VideoServiceInterface
{
    /**
     * @var VideoRepositoryInterface
     */
    protected $videoRepository;

    /**
     * VideoService constructor.
     * @param VideoRepositoryInterface $videoRepository
     */
    public function __construct(VideoRepositoryInterface $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }

    /**
     * @return array
     */
    public function index()
    {
        $videos = $this->videoRepository->getAll();

        return $videos;
    }

}