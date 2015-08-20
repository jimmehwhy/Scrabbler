<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Model\WordsModel;

/**
 * @Route("/")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('letters', 'text')
            ->add('submit', 'submit', array('label' => 'Generate words'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {

            $model = new WordsModel();
            $data = $form->getData();
            $letters=$data["letters"];

            $words = $model->getWords($letters);

            return $this->render('AppBundle:Default:wordlist.html.twig', array('form' => $form->createView(), 'letters' => $letters, 'words' => $words, 'count' => count($words)));
        }

        return $this->render('AppBundle:Default:index.html.twig', array('form' => $form->createView()));
    }

}
