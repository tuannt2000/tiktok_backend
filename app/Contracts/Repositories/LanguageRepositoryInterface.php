<?php
namespace App\Contracts\Repositories;

interface LanguageRepositoryInterface extends BaseRepositoryInterface
{
    //lấy ra 5 ngôn ngữ 
    public function getLanguages();
}