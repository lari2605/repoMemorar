<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     *@Route("/user", methods={"GET"})
     */
    public function getUser()
    {
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        $serializer = $this->get('serializer');
        $data = $serializer->serialize($users, 'json');

        return new Response(
            $data,
            200,
            ['Access-Control-Allow-Origin' => 'http://localhost:8080'],
            ['Access-Control-Allow-Credentials' => 'true'],
            ['Access-Control-Allow-Methods' => 'GET, POST']
        );
    }

    /**
     *@Route("/user", methods={"POST"})
     */

    public function postUser(Request $request, UserPasswordEncoderInterface $encoder): Response
    {

        $users = new User();
        $users->setName($request->get('name'));
        $users->setTelephoneNumber($request->get('telephoneNumber'));
        $users->setBirthDate(new \DateTime($request->get('birthDate')));
        $users->setEmail($request->get('email'));
        $plainPassword = $request->get('password');
        $encoded = $encoder->encodePassword($users, $plainPassword);
        $users->setPassword($encoded);
        $users->setCpf($request->get('cpf'));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($users);
        $entityManager->flush();

        return new Response(
            'Inserido com sucesso',
            200,
            ['Access-Control-Allow-Origin' => 'http://localhost:8080'],
            ['Access-Control-Allow-Credentials' => 'true'],
            ['Access-Control-Allow-Methods' => 'GET, POST']
        );
    }
}
