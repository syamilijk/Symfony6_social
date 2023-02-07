<?php

namespace App\Controller;

use DateTime;
use App\Entity\MicroPost;
use PhpParser\Node\Stmt\Label;
use App\Repository\MicroPostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MicroPostController extends AbstractController
{
    #[Route('/micro-post', name: 'app_micro_post')]
    public function index(MicroPostRepository $posts): Response
    {
        return $this->render('micro_post/index.html.twig', [
            'posts' => $posts->findAll()
        ]);
    }

    #[Route('micro-post/{post}', name: 'app_micro_post_show')]
    public function showOne(MicroPost $post): Response
    {

        return $this->render('micro_post/show.html.twig', [
            'post' => $post
        ]);
    }

    #[Route('micro-post/add', name:'app_micro_post_add', priority:2)]
    public function add(Request $request, MicroPostRepository $posts): Response
    {
        $microPost = new MicroPost();
        $form = $this->createFormBuilder($microPost)
                ->add('title')
                ->add('text')
                ->getForm();

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $post = $form->getData();
            $post->setCreated(new DateTime());
            $posts->save($post, true);
            
            // Add a flash message
            $this->addFlash('success', 'Your micr post have been added successfully!');

            // Redirect
            $this->redirectToRoute('app_micro_post');
        }

        return $this->renderForm('micro_post/add.html.twig',[
            'form' => $form
        ]);
    }
}
