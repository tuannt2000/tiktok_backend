<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 7/8/2022
 * Time: 3:37 PM
 */

namespace App\Repositories;

use App\Contracts\Repositories\MusicRepositoryInterface;
use App\Models\Music;
use Illuminate\Support\Facades\DB;

class MusicRepository extends BaseRepository implements MusicRepositoryInterface
{
    /**
     * MusicRepository constructor.
     * @param Music $music
     */
    public function __construct(Music $music)
    {
        parent::__construct($music);
    }

    public function getAll()
    {
        return $this->model->select('musics.*', DB::raw("'music' AS type"));
    }
}