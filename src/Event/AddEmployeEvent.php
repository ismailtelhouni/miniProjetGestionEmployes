<?php

namespace App\Event;

use App\Entity\Employes;
use Symfony\Contracts\EventDispatcher\Event;

class AddEmployeEvent extends Event
{
    const Add_Employe_Event = "employes_add";//app_employes_add

    public function __construct( private Employes $employe )
    {
        
    }
    public function getEmployes() : Employes
    {
        return $this->employe ;
    }
}