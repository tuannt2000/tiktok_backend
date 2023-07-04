<?php

namespace App\Repositories;

use App\Contracts\Repositories\LanguageRepositoryInterface;
use App\Models\Language;

class LanguageRepository extends BaseRepository implements LanguageRepositoryInterface
{
    /**
     * LanguageRepository constructor.
     * @param Language $language
     */
    public function __construct(Language $language)
    {
        parent::__construct($language);
    }

    public function getLanguages()
    {
        return $this->model->select('title')->take(5)->get();
    }
}