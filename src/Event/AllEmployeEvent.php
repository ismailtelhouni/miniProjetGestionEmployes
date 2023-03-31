<?php

namespace App\Event;

use App\Entity\Employes;
use Symfony\Contracts\EventDispatcher\Event;

class AllEmployeEvent extends Event
{
    const All_Employe_Event = "employes_all";

    public function __construct( private int $nbEmployes )
    {
        
    }
    public function getNbEmployes() : int
    {
        return $this->nbEmployes ;
    }
}