<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\BlogPost;
use App\Entity\BlogComm;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\BlogPostRepository;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * @Route("/blog")
*/
class BlogController extends Controller
{
    /**
     * @Route("/{page}", name="blog",requirements={"page"="\d+"})
     */
    public function index(BlogPostRepository $blogPostRepository,  $page = 0)
    {
    $rep = $this->getDoctrine()->getRepository(BlogPost::class);
    $posts = $rep->findAll();

    $postsPage = $blogPostRepository->findParPage($page, 3);

   



        return $this->render('Blog/index.html.twig' ,[
            'user' => $this->getUser(),
            'post' => $postsPage,
            'page' => $page
            
        ]);
    }

    /**
     * @Route("/search", name="search")
     */
    public function search(BlogPostRepository $blogPostRepository, Request $request)
    {
        if ($request->isMethod('POST')){
            $value = $request->request->get('value');
            $posts = $blogPostRepository->search($value);
            return $this->render('Blog/search.html.twig',['value' => $value, 'posts' =>$posts ]);
        }
       
        return $this->render('Blog/search.html.twig');
    }

    /**
     * @Route("/posts/{name}",name="post")
     */
    public function post($name, Request $request)
    {
        $req = $this->getDoctrine()->getRepository(BlogPost::class);
        $post = $req->findOneby(['id' => $name]);
        $user = $this->getUser();
        
        $comm = new BlogComm();
        $comm->setPostDate(new \Datetime('now'));
        $comm->setAuthor($user);
        $comm->setPost($post);
        
        $form = $this->createFormBuilder($comm)
        ->add('post_content', TextareaType::class)            
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
             // On enregistre l'utilisateur dans la base
            $em = $this->getDoctrine()->getManager();
            $em->persist($comm);
            $em->flush();
 

 
            return $this->redirectToRoute('post', ['name' => $name]);
        }

        //Il faut générer le formulaire pour les commentaires et les afficher
        return $this->render('Blog/post.html.twig',['post' => $post, 'form' => $form->createView(), 'user' => $this->getUser()]);
    }
}
