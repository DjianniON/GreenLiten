<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Project;
use App\Entity\Donation;

/**
 * @Route("/profile")
 */
class UserController extends Controller
{
    /**
     * @Route("/", name="profile")
     */
    public function index()
    {
        $user = $this->getUser();
        $rep = $this->getDoctrine()->getRepository(Donation::class);
        $donlist = $rep->findBy(['user' => $user]);
        return $this->render('Profile/index.html.twig',['user' => $this->getUser(),
        'donlist' => $donlist
        ]);
    }

    /**
     * @Route("/edit", name="edit")
     */
    public function edit(UserPasswordEncoderInterface $passwordEncoder)
    {

        $password = $passwordEncoder->encodePassword($user, $user->getPassword());
        $ent = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);

        $user->setPassword($password);
        $ent->flush();

        return $this->redirectToRoute('edit_confirm',['user' => $this->getUser()]);
    }
}
