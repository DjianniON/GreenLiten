<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Project;
use App\Entity\Donation;
use App\Events;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class MainController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('Main/index.html.twig',['user' => $this->getUser()]);
    }

    //Pê route admin si jamais..

    /**
     * @Route("/about", name="about")
     */
    public function about()
    {
        return $this->render('Main/about.html.twig',['user' => $this->getUser()]);
    }

    /**
     * @Route("/donate", name="donate")
     */
    public function donate(Request $request, EventDispatcherInterface $eventDispatcher)
    {
        $user = $this->getUser();
        $don = new Donation();
        $don->setDonDate(new \Datetime('now'));
        $don->setUser($user);
        $form = $this->createFormBuilder($don)
        ->add('don_value', IntegerType::class)
        ->add('don_comm', TextareaType::class)
        ->add('project', EntityType::class, [
            'class' => Project::class,
            'choice_label' => 'pr_title',
            ])
        ->getForm();


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
             // On enregistre l'utilisateur dans la base
            $em = $this->getDoctrine()->getManager();
            $em->persist($don);
            $em->flush();


            $event = new GenericEvent($user);
            $eventDispatcher->dispatch(Events::DONATION_DONE, $event);
            return $this->redirectToRoute('confirm');
        }

        $rep = $this->getDoctrine()->getRepository(Project::class);
        $repDon = $this->getDoctrine()->getRepository(Donation::class);
        $donations = $repDon->findAll();
        $projects = $rep->findBy(['pr_status' => 'PROGRESS']);
        return $this->render('Main/donate.html.twig', ['projects' => $projects, 'form' => $form->createView(), 'user' => $this->getUser(), 'dons' => $donations]);


    }

    /**
     * @Route("/donate/confirm", name="confirm")
     */
    public function confirm()
    {

        return $this->render('Main/confirm.html.twig',['user' => $this->getUser()]);
    }



    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        return $this->render('contact.html.twig',['user' => $this->getUser()]);
    }

    /**
     * @Route("/terms", name="terms")
     */
    public function terms()
    {
        return $this->render('terms.html.twig',['user' => $this->getUser()]);
    }
}
