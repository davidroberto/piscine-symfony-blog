<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PokerController extends AbstractController
{

    #[Route('/poker', name: 'poker')]
    public function poker(): Response {

        $request = Request::createFromGlobals();

        if (!$request->query->has('age')) {
            return $this->render('page/poker_form.html.twig');
        } else {
            $age = $request->query->get('age');

            if ($age >= 18) {
                return $this->render('page/poker_welcome.html.twig');
            } else {
                return $this->render('page/get_out.html.twig');
            }
        }


    }

}