<?php

namespace App\EventListener;

use App\Event\AllEmployeEvent;
use Psr\Log\LoggerInterface;

class EmployeeListener
{
    public function __construct(private LoggerInterface $logger)
    {
        
    }
    public function onEmployesAdd()
    {
        $this->logger->debug("on add employee ");
    }
    public function onEmployesAll(AllEmployeEvent $Event)
    {
        $this->logger->debug("le nombre des employes est ".$Event->getNbEmployes()." ");
    }
}