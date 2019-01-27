<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\CmsType;
use App\Services\Tranlit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CMSController extends AbstractController
{
    /**
     * @Route("/CMS", name="CMS")
     */
    public function index(Request $request, Tranlit $tranlit)
    {
        $post = new Post();

        $form = $this->createForm(CmsType::class, $post, [
        ]);

        $request = Request::createFromGlobals();

        $login = 'login';
        $pass =  'pass';

        if ($request->query->get('_hkeyp') == $pass && $request->query->get('_hkeyu') == $login)
        {
            $form->handleRequest($request);

           // var_dump($pass);

            if ($form->isSubmitted() && $form->isValid())
            {
                //saving to the DB
                $em = $this->getDoctrine()->getManager();

               // return $this->render('dump.html.twig', ['var' => $tranlit->translit($post->getHeader())]);

                $post->setHearts('0');
                $post->setViews('0');
                $post->setSlug($tranlit->translit($post->getHeader()));
                $post->setDate(date('d-m-Y'));

//                if($form['Text']->getData() == 'PicOnly')
//                {
//                    $post->setText(' ');
//                }

                $em->persist($post);
                $em->flush();

              echo '<p style="color:green;">Пост выложен в ленту.</p>';

            }

            return $this->render('cms/index.html.twig', [

                'post_form' => $form->createView()


            ]);

       }

        return $this->render('cms/login.html.twig');

    }
}

