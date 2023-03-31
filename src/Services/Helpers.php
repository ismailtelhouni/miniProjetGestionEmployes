<?php

namespace App\Services;

use App\Entity\User;
use Symfony\Component\Security\Core\Security;

class Helpers
{
    public function __construct(private Security $security)
    {
        
    }
    public function getUser(): User
    {
        return $this->security->getUser();
    }
}