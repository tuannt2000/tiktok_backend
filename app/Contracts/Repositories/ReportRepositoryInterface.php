<?php
namespace App\Contracts\Repositories;

interface ReportRepositoryInterface extends BaseRepositoryInterface
{
    public function updateCancelReports($video_id);
}