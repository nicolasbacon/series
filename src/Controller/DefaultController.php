<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        $series = ["a","b","Dexter"];
        $title = "pouf pif";
        return $this->render("default/home.html.twig", [
            "series" => $series,
            "title" => $title,
        ]);
    }

    /**
     * @Route("/test/yo", name="test")
     */
    public function test()
    {
        $content = "dsadsa";
        return $this->render("default/test.html.twig",[
            "content" => $content,
        ]);
    }
}