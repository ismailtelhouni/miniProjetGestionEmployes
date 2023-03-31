<?php

namespace App\model;

use Doctrine\ORM\Mapping as ORM;

class SearchData    
{
    #[ORM\Column]
    private ?string $Search = '';

    public function getSearch():string
    {
        return $this->Search;
    }
    public function setSearch($Search)
    {
        $this->Search = $Search;    
    }
}