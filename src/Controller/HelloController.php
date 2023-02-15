<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Entity\Comment;
use App\Entity\MicroPost;
use App\Entity\Test\Tester;
use App\Entity\UserProfile;
use App\Repository\MicroPostRepository;
use App\Repository\Test\TesterRepository;
use App\Repository\UserProfileRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HelloController extends AbstractController
{
    private array $messageArray = [
        ['message' => 'hello', 'created' => '2022/09/12'],
        ['message' => 'hi', 'created' => '2022/07/12'],
        ['message' => 'bye', 'created' => '2021/03/11'],
    ];

    public function __construct(){
        $this->messages = $this->messageArray;
    }

    #[Route('/', name: 'app_index')]
    public function index(MicroPostRepository $posts): Response{

        $post = new MicroPost();
        $post->setTitle('Hello');
        $post->setText('Hello');
        $post->setCreated(new DateTime());

        $comment = new Comment();
        $comment->setText('Hello');

        $post->addComment($comment);
        $posts->save($post, true);

        // $user = new User();
        // $user->setEmail('email123@email.com');
        // $user->setPassword('123456789');
        

        // $profile = new UserProfile();
        // $profile->setUser($user);
        // $profiles->save($profile, true);

        // $profile = $profiles->find(1);
        // $profiles->remove($profile, true);

        return $this->render(
            'hello/index.html.twig',
            [
                'messages' => $this->messages,
                'limit' => 3
            ]
        
        );
    }

    #[Route('/hello', name: 'app_hello')]
    public function hello(): Response
    {
        return $this->render('hello/index.html.twig', [
            'controller_name' => 'HelloController',
        ]);
    }

    #[Route('/messages/{limit?1}', name: 'app_message')]
    public function showMessage($limit) : Response{
        //return new Response(implode(',', array_slice($this->messageArray, 0, $limit)));
        //return new Response($this->messageArray[$id]);
        return $this->render('hello/message.html.twig',[
            'messages' => $this->messageArray,
            'limit' => $limit
        ]);
    }

    #[Route('/message/{id<\d+>}', name: 'app_message_by_id')]
    public function showMessageById(int $id) : Response{
        if(array_key_exists($id, $this->messageArray)){
            return new Response($this->messageArray[$id]);
        }
       return new Response("No message found");
    }
}
