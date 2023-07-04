<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 7/8/2022
 * Time: 3:37 PM
 */

namespace App\Repositories;

use App\Contracts\Repositories\ShareRepositoryInterface;
use App\Models\Share;

class ShareRepository extends BaseRepository implements ShareRepositoryInterface
{
    /**
     * ShareRepository constructor.
     * @param Share $share
     */
    public function __construct(Share $share)
    {
        parent::__construct($share);
    }
}