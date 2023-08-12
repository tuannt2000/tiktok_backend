<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 7/6/2022
 * Time: 3:20 PM
 */

namespace App\Services\Admin;

use App\Contracts\Repositories\ReportRepositoryInterface;
use App\Contracts\Repositories\VideoRepositoryInterface;
use App\Contracts\Services\Admin\VideoServiceInterface;
use App\Models\Report;
use App\Models\User;
use App\Models\Video;
use App\Services\AbstractService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class VideoService extends AbstractService implements VideoServiceInterface
{
    /**
     * @var VideoRepositoryInterface
     */
    protected $videoRepository;

    /**
     * @var ReportRepositoryInterface
     */
    protected $reportRepository;

    /**
     * VideoService constructor.
     * @param VideoRepositoryInterface $videoRepository
     * @param ReportRepositoryInterface $reportRepository
     */
    public function __construct(VideoRepositoryInterface $videoRepository, ReportRepositoryInterface $reportRepository)
    {
        $this->videoRepository = $videoRepository;
        $this->reportRepository = $reportRepository;
    }

    /**
     * @return array
     */
    public function index()
    {
        $videos = $this->videoRepository->getAll();

        return $videos;
    }

    public function getVideoReports()
    {
        $videos = $this->videoRepository->getVideoReports();

        return $videos;
    }

    public function updateCancelReports($video_id)
    {
        $result = $this->reportRepository->updateCancelReports($video_id);

        return $result;
    }

    public function deleteVideoReport($video_id)
    {
        DB::beginTransaction();
        try {
            $video = Video::findOrFail($video_id);
            Storage::disk('google')->deleteDirectory($video->path_directory);
            User::where('id', $video->user_id)->update([
                'status' => 'L',
                'date_limit' => date("Y-m-d")
            ]);
            Report::where('video_id', $video_id)->update([
                'progress' => 'processed'
            ]);

            if ($this->videoRepository->delete($video_id)) {
                DB::commit();
                return true;
            }

            DB::rollBack();
        } catch (\Throwable $err) {
            DB::rollBack();
            Log::error($err);
        }
           
        return false;
    }
}