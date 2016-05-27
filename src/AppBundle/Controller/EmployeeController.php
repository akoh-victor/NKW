<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EmployeeController extends Controller
{
    /**
     * @Route("/register/employee", name = "employee-registration")
     */
    public function registerAction()
    {
        return $this->container
            ->get('pugx_multi_user.registration_manager')
            ->register('AppBundle\Entity\Employee');
    }
}