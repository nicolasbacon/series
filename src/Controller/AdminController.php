<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * page home
     * @Route("", name="admin_home")
     */
    public function home()
    {
        return new Response("ok!");
    }

    /**
     * @Route("/test", name="admin_test")
     */
    public function test()
    {
        return new Response("ok!");
    }
}
