<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    private array $messageArray = [
        ['message' => 'hello', 'created' => '2022/09/12'],
        ['message' => 'hi', 'created' => '2022/07/12'],
        ['message' => 'bye', 'created' => '2021/03/11'],
    ];

    #[Route('/', name: 'app_index')]
    public function index(): Response{
        return $this->render('hello/index.html.twig');
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
