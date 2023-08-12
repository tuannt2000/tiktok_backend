<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 7/8/2022
 * Time: 3:37 PM
 */

namespace App\Repositories;

use App\Contracts\Repositories\ReportRepositoryInterface;
use App\Models\Report;

class ReportRepository extends BaseRepository implements ReportRepositoryInterface
{
    /**
     * ReportRepository constructor.
     * @param Report $report
     */
    public function __construct(Report $report)
    {
        parent::__construct($report);
    }

    public function updateCancelReports($video_id) {
        $query = $this->model->where('video_id', $video_id)->update([
            'progress' => 'cancel'
        ]);

        if ($query) {
            return true;
        }

        return false;
    }
}