<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\SearchByGet;


class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(SearchByGet $byGet)
    {

        //$post = new Post();

        $em = $this->getDoctrine()->getManager()->getRepository(Post::class);

        $post_from_db = $em->getPostDESC();

        $post_count = count($post_from_db)-1; // так как отсчет не с 0.

        $mini_post_from_db = $em->getOnePost();

        $med_post_from_db =  $em->getOnePost();

       // return $this->render('dump.html.twig', ['var' => $post_from_db[0]->getDate()->format('Y-m-d H:i:s')]);


        if(!empty($_GET)){


            return $this->render('main/search.html.twig', [

                'post_count' => count($byGet->searchByGet($em)) - 1,
                'post' =>$byGet->searchByGet($em),

            ]);
        }


        return $this->render('main/index.html.twig', [

            'med_post' => $med_post_from_db,
            'one_post' => $mini_post_from_db,
            'post' => $post_from_db,
            'post_count' => $post_count

        ]);
    }

    /**
     * @Route("/page-{num_page<\d+>}", name="page")
     */
    public function page($num_page, SearchByGet $byGet)
    {
        $next_twig_page = (int)$num_page;
        $prev_twig_page = (int)$num_page;

        $em = $this->getDoctrine()->getManager()->getRepository(Post::class);

        $countOfPost = $em->getCountofTable();

        //(int)$countOfPost["COUNT(*)"]

        $pageForPost = intdiv((int)$countOfPost["COUNT(*)"]-1, 4);

        if($num_page > $pageForPost)
            throw new NotFoundHttpException('Sorry not existing!');

        if($pageForPost == $num_page)
            $twig = 'disabled';
        else $twig = ' ';

        $page_count = $num_page*4;

        $post = $em->getPostBetween($page_count);

        $count_post =count($post) - 1;

        if(!empty($_GET)){

            return $this->render('main/search.html.twig', [

                'post_count' => count($byGet->searchByGet($em)) - 1,
                'post' =>$byGet->searchByGet($em),

            ]);
        }



        //return $this->render('dump.html.twig', ['var' => ]);


        return $this->render('main/page.html.twig', [

            'current_page' => (int)$num_page,
            'button_status' => $twig,
            'post_count' => $count_post,
            'post_page' => $post,
            'next_num_page' => ++$next_twig_page,
            'prev_twig_page' => --$prev_twig_page,

        ]);
    }

    /**
     * @Route("{post_slug}", name="post_slug")
     */
    public function post($post_slug, SearchByGet $byGet)
    {
        $em = $this->getDoctrine()->getManager();

        $post = $em->getRepository(Post::class)->findOneBy([
            'Slug' =>  $post_slug
        ])
        ;

        if($post_slug == "random")
        {
            $post = $em->getRepository(Post::class)->getOnePost();

           $text = $post[0]['text'];
           
            return $this->render('main/random.html.twig', [
                'hleb_crosh_link' => $byGet->strToURL($post[0]['tag']),
                'hleb_crosh' => $post[0]['tag'],
                'post_page' => $post,
            ]);
        }

        if($post_slug == "about")
        {
            if(!empty($_GET)){


                return $this->render('main/search.html.twig', [

                    'post_count' => count($byGet->searchByGet($em->getRepository(Post::class))) - 1,
                    'post' =>$byGet->searchByGet($em->getRepository(Post::class)),

                ]);
            }

            return $this->render('main/about.html.twig');
        }


        if(!empty($_GET)){


            return $this->render('main/search.html.twig', [

                'post_count' => count($byGet->searchByGet($em->getRepository(Post::class))) - 1,
                'post' =>$byGet->searchByGet($em->getRepository(Post::class)),

            ]);
        }

        if($post_slug == "vietnam")
        {



                return $this->render('main/search.html.twig', [

                    'post_count' => count($byGet->searchByURL($em->getRepository(Post::class), $post_slug)) - 1,
                    'post' =>$byGet->searchByURL($em->getRepository(Post::class), $post_slug),

                ]);
        }

        if($post_slug == "chechnya")
        {


                return $this->render('main/search.html.twig', [

                    'post_count' => count($byGet->searchByURL($em->getRepository(Post::class), $post_slug)) - 1,
                    'post' =>$byGet->searchByURL($em->getRepository(Post::class), $post_slug),

                ]);
        }

        if($post_slug == "arab–israeli")
        {
                return $this->render('main/search.html.twig', [

                    'post_count' => count($byGet->searchByURL($em->getRepository(Post::class), $post_slug)) - 1,
                    'post' =>$byGet->searchByURL($em->getRepository(Post::class), $post_slug),

                ]);
        }


        if($post_slug == "iraq")
        {
                return $this->render('main/search.html.twig', [

                    'post_count' => count($byGet->searchByURL($em->getRepository(Post::class), $post_slug)) - 1,
                    'post' =>$byGet->searchByURL($em->getRepository(Post::class), $post_slug),

                ]);

        }

        if($post_slug == "pmv")
        {
            return $this->render('main/search.html.twig', [

                'post_count' => count($byGet->searchByURL($em->getRepository(Post::class), $post_slug)) - 1,
                'post' =>$byGet->searchByURL($em->getRepository(Post::class), $post_slug),

            ]);

        }



        $numOfViewsFromDB =  $post->getViews();

        $numOfViewsFromDB++;

        $post->setViews($numOfViewsFromDB);

        $em->flush();

        $text = $post->getText();

        $readMoreLink = $em->getRepository(Post::class)->getOnePost();

        while($readMoreLink[0]['slug'] == $post->getSlug())
            $readMoreLink = $em->getRepository(Post::class)->getOnePost();

       // return $this->render('dump.html.twig', ['var' =>   $text_split]);

        return $this->render('main/single_post.html.twig', [
            'readMoreLink' => $readMoreLink,
            'hleb_crosh_link' => $byGet->strToURL($post->getTag()),
            'hleb_crosh' => $post->getTag(),
            'post_page' => $post,
        ]);

    }


}
