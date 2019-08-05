<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Depot;
use App\Entity\Compte;
use App\Form\DepotType;
use App\Entity\Entreprise;
use App\Form\EntrepriseType;
use App\Repository\EntrepriseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\DatetimeInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/** 
 * @Route("/api")
 */
class EntrepriseController extends AbstractController
{
    /** 
     * @Route("/entreprise", name="entreprise", methods={"POST"})
     */
    public function enregistrer(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $random=random_int(100000,999999);
        $values = json_decode($request->getContent());

        $user= new User();
        $user->setUsername($values->username);
        $user->setPassword($passwordEncoder->encodePassword($user, $values->password));
        $user->setNom($values->nom);
        $user->setPrenom($values->prenom);
        $user->setEmail($values->email);
        $user->setTelephone($values->telephone);
        $user->setNci($values->nci);
        $user->setStatus($values->status);
        $user->setRoles(array('ROLE_ADMIN'));
      

        $entreprise= new Entreprise();
        $entreprise->setRaisonsociale($values->raisonsociale);
        $entreprise->setNinea($values->ninea);
        $entreprise->setAdresse($values->adresse);
        $entreprise->setStatus($values->status);
        $user->setEntreprise($entreprise);


        $compte= new Compte();
        $compte->setNumcompte($random);
        $compte->setSolde($values->solde);
        $compte->setEntreprise($entreprise);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->persist($entreprise);
        $entityManager->persist($compte);
        $entityManager->flush();

        
          
        return new Response('L\'entreprise a été ajouté',Response::HTTP_CREATED); 
    }


     /** 
     * @Route("/depot", name="depot", methods={"POST"})
     */


    public function depot(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder): Response


    {
         $values = json_decode($request->getContent());

         $depot = new Depot();
        
           

         $depot->setDate(new \DateTime());
         $depot->setMontant($values->montant);
         $depot->setSoldeactuele($values->soldeactuele);
         ;
         $entityManager->persist($depot);
         $entityManager->flush();

         return new Response('Depot reussie',Response::HTTP_CREATED); 


    
        



}

}