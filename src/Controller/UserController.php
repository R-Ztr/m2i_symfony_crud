<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;


class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(SessionInterface $session): Response
    {
        if(!$session->has('users')) {
            $session->set('users', [
                ['name' => 'Alice', 'email' => 'alice@gmail.com', 'age' => 45],
                ['name' => 'Pierre', 'email' => 'pierre@gmail.com', 'age' => 78],
                ['name' => 'Martin', 'email' => 'martin@gmail.com', 'age' => 34]
                ]);

        }
        $users = $session->get('users');

        return $this->render('user/index.html.twig', [
            'users' => $users,
            'title' => 'Liste des utilisateurs',
        ]);
    }

    #[Route('/user/details', name: 'user_details')]
    public function detail(Request $request): Response{

        $name = $request->query->get('name');
        $email = $request->query->get('email');
        $age = $request->query->get('age');

        return $this->render('user/details.html.twig', [
            'title' => 'Details d\' un utilisateur',
            'name' => $name,
            'email' => $email,
            'age' => $age
        ]);


    }

}
