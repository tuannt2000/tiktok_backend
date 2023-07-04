<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Services\Api\VideoServiceInterface;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    protected $videoService;

    public function __construct(VideoServiceInterface $videoService)
    {
        $this->videoService = $videoService;
    }

    public function index(Request $request) {
        $offset = $request->offset ?? 0;
        $result = $this->videoService->index($offset);

        return response()->json($result, 200);
    }

    public function getVideo($id) {
        $result = $this->videoService->getVideoById($id);

        return response()->json($result, $result['code']);
    }

    public function getVideoNotLogin() {
        $result = $this->videoService->getVideoNotLogin();

        return response()->json($result, 200);
    }

    public function following(Request $request) {
        $offset = $request->offset ?? 0;
        $result = $this->videoService->following($offset);

        return response()->json($result, 200);
    }

    public function getMyVideo(Request $request) {
        $result = $this->videoService->getMyVideo($request->id);

        return response()->json($result, 200);
    }

    public function getMyVideoLike() {
        $result = $this->videoService->getMyVideoLike();

        return response()->json($result, 200);
    }

    public function delete(Request $request) {
        $result = $this->videoService->delete($request->id);

        return response()->json($result, $result['code']);
    }

    public function edit(Request $request) {
        $result = $this->videoService->edit($request->all());

        return response()->json($result, $result['code']);
    }

    /**
      * @param Request $request
      *
      * @return \Illuminate\Http\Response
     */
    public function upload(Request $request) {
        try {
            $video = $request->file('video_file');
            $cover_image = $request->file('cover_image_file');

            if (!$video->isValid() || !$cover_image->isValid()) {
                throw new \Exception('file error');
            }
            if (!$request->hasFile('video_file') || !$request->hasFile('cover_image_file')) {
                throw new \Exception('not file');
            }
            $file_name = $video->getClientOriginalName();
            $folder_name = pathinfo($file_name, PATHINFO_FILENAME);
            $link = Auth::user()->id . '/' . date('Y_m_d_H_i_s_', strtotime(Carbon::now())) . $folder_name;
            $request['path_directory'] = $link;
            $request['url'] = $this->__createUrlFile($link . '/' . $file_name, $video);
            if (is_null($request['url'])) {
                throw new \Exception('Upload failed');
            }
            $request['cover_image'] = $this->__createUrlFile($link . '/' . $folder_name . ".png", $cover_image);
            if (is_null($request['cover_image'])) {
                throw new \Exception('Upload failed');
            }
            $result = $this->videoService->uploadVideo($request->all());

            return response()->json($result, 200);
        } catch (\Throwable $err) {
            Log::error($err);
            return response()->json('Upload file thất bại!', 500);
        }
    }

    /**
      * @param Request $request
      *
      * @return \Illuminate\Http\Response
     */
    public function like(Request $request) {
        $result = $this->videoService->likeVideo($request->all());

        return response()->json($result, $result['code']);
    }

    /**
      * @param Request $request
      *
      * @return \Illuminate\Http\Response
     */
    public function findTopVideo(Request $request) {
        $result = $this->videoService->findTopVideo($request->q ? urldecode($request->q) : '');

        return response()->json($result, $result['code']);
    }

    /**
      * @param Request $request
      *
      * @return \Illuminate\Http\Response
     */
    public function report(Request $request) {
        $result = $this->videoService->report($request->all());

        return response()->json($result, $result['code']);
    }

    /**
      * @param Request $request
      *
      * @return \Illuminate\Http\Response
     */
    public function share (Request $request) {
        $result = $this->videoService->share($request->all());

        return response()->json($result, $result['code']);
    }

    /**
      * create path url
      * @param string $link
      * @param file $file
      *
      * @return string $url
     */
    private function __createUrlFile($link, $file) {
        try {
            $file->storeAs('', $link, 'google');
            return $link;
        } catch (\Exception $e) {
            Log::error($e);
        }

        return null;
    }
}
