<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class TodoController extends Controller
{
    /**
     * @Route("/todo")
     */
    public function indexAction(Request $request)
    {
        $session = $request->getSession();
        if(! $session->has('mesTodos')) {
            $mesTodos = array(
                'lundi' => 'Aller Travailler en boudant',
                'mardi' => 'Travailler le Web'
            );
            $session->set('mesTodos', $mesTodos);
            $session->getFlashBag()->add('success', 'La liste des todos a été ajouté avec succées');
        }
        return $this->render('@App/Todo/index.html.twig');
    }

}
