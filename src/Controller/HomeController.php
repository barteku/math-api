<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{

    /**
     * @Route('/', name: 'app_home')]
     *
     */
    public function homepage():Response
    {

        return new Response(
            '<html><body><h1>Welcome to API task</h1></body></html>'
        );
    }


}
