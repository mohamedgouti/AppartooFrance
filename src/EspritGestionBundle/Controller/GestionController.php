<?php

namespace EspritGestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EspritUserBundle\Entity\User;
use EspritUserBundle\Form\RegistrationFormType;
use Symfony\Component\HttpFoundation\Request;
use EspritUserBundle\Form\RegistrationEditFormType;
class GestionController extends Controller
{
    
    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();  
        $users=$em->getRepository('EspritUserBundle:User')->findAll();
        $user = new User();
        $form = $this->createForm(new RegistrationFormType(),$user);
        if ($request->isMethod('Post')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $user = $form->getData();                          
                $em->persist($user);
                $em->flush();
                $this->addFlash(
                        'notice',
                        'Membre à été ajouté avec succés!'
                    );

               return $this->redirectToRoute('AppartooParisGestionIndex');
            }            
        }

         return $this->render('EspritGestionBundle:Default:add.html.twig', array('form' => $form->createView(),'users'=>$users));
    }
    
    
      public function editAction($username, Request $request) {
          
        $em = $this->getDoctrine()->getManager();
        $users=$em->getRepository('EspritUserBundle:User')->findAll();
        $User = $em->getRepository('EspritUserBundle:User')->findOneBy(array('username' => $username));               
        if (!$User) {
            throw $this->createNotFoundException('Aucune donnée disponible');
        }        
        $form = $this->createForm(new RegistrationEditFormType(), $User);
        
        if ($request->isMethod('Post')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $User = $form->getData();                  
                $em->persist($User);
                $em->flush();
                 $this->addFlash(
                        'notice',
                        'Membre à été modifié avec succés!'
                    );

               return $this->redirectToRoute('AppartooParisGestionEdit',array('username'=> $username));                
            }              
        }
         return $this->render('EspritGestionBundle:Default:update.html.twig', array('form' => $form->createView(),'users'=>$users));
    }
     
     public function deleteAction($username, Request $request) {
          
       
        $em = $this->getDoctrine()->getManager();
         $User = $em->getRepository('EspritUserBundle:User')->findOneBy(array('username' => $username));               
        if (!$User) {
            throw $this->createNotFoundException('Aucune donnée disponible');
        }     
       
        $em->remove($User);
        $em->flush();
        $this->addFlash(
                        'notice',
                        'Membre à été supprimé avec succés!'
                    );
        return $this->redirectToRoute('AppartooParisGestionIndex');
     
     }  
}