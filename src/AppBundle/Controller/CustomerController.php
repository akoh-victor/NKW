<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Wish;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

class CustomerController extends Controller
{
    public function registerAction()
    {
        return $this->container
            ->get('pugx_multi_user.registration_manager')
            ->register('AppBundle\Entity\Customer');
    }
}