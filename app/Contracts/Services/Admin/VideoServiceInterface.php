<?php

namespace App\Contracts\Services\Admin;

interface VideoServiceInterface
{
    public function index();
    public function getVideoReports();
    public function updateCancelReports($video_id);
    public function deleteVideoReport($video_id);
}