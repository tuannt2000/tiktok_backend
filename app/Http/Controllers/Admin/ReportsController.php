<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\Services\Admin\VideoServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReportsController extends Controller
{
    protected $videoService;

    public function __construct(VideoServiceInterface $videoService)
    {
        $this->videoService = $videoService;
    }

    public function index () {
        $video_reports = $this->videoService->getVideoReports();

        return view('content.reports.index', compact('video_reports'));
    }

    public function cancelReport ($video_id) {
        $result = $this->videoService->updateCancelReports($video_id);

        if ($result) {
            Session::flash('success', 'Cancel reports successfully'); 
        } else {
            Session::flash('error', 'Cancel reports failed'); 
        }

        return redirect()->back();
    }

    public function deleteVideoReport ($video_id) {
        $result = $this->videoService->deleteVideoReport($video_id);

        if ($result) {
            Session::flash('success', 'Delete video successfully'); 
        } else {
            Session::flash('error', 'Delete video failed'); 
        }

        return redirect()->back();
    }
}
