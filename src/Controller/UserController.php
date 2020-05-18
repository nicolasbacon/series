<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request,
                             EntityManagerInterface $em,
                             UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $user->setDateCreated(new \DateTime());

        $registerForm = $this->createForm(RegisterType::class, $user);
        $registerForm->handleRequest($request);

        if ($registerForm->isSubmitted() && $registerForm->isValid()) {
            //hasher le mot de passe
            $hashed = $encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($hashed);

            $em->persist($user);
            $em->flush();
        }

        return $this->render("user/register.html.twig",[
            'registerForm' => $registerForm->createView()
        ]);
    }

    /**
     * @Route("/login", name="login")
     */
    public function login()
    {


        return $this->render("user/login.html.twig", [

        ]);
    }

    /**
     * Symfony gere entierement cette route
     * @Route("/logout", name="logout")
     */
    public function logout(){}
}
