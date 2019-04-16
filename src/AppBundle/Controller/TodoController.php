<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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

    /**
     * @param $titre
     * @param $contenu
     * @Route("/todo/add/{titre}/{contenu}")
     */
    public function addAction(Request $request, $titre, $contenu) {
        // vérifier lexistance de la session
        $session = $request->getSession();
        if(!$session->has('mesTodos')) {
            // !ok
            // message erreur
            $session->getFlashBag()->add('error', "La liste des todos est innexistante");
        } else {
            //si ok
            // Vérifier que le todo n'existe pas déja
            $mesTodos = $session->get('mesTodos');
            if (isset($mesTodos[$titre])) {
                // si oui
                // Message erreur
                $session->getFlashBag()->add('error', "Le todo ${titre} existe déjà");
            } else {
                $mesTodos[$titre] = $contenu;
                $session->set('mesTodos', $mesTodos);
                $session->getFlashBag()->add('success', "Le todo ${titre} a été ajouté avec succées");
            }
        }
        return $this->forward('AppBundle:Todo:index');
    }


}
