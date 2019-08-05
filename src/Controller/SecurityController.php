<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Entreprise;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/api")
 */
class SecurityController extends AbstractController
{
    /**
     * @Route("/register", name="register", methods={"POST"})
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager)
    {
        $values = json_decode($request->getContent());
        if(isset($values->username,$values->password)) {
            $user = new User();
            // $repository = $this->getDoctrine()->getRepository(Entreprise::class);//sa me permet de retourner le repository entreprise
            // $entreprise=$repository->find($values->entreprise);// $values->Entreprise me permet de recuperer l'id de l'entreprise && $repository->find sa me permet de retourner l'objet de type entreprise && $entreprise est l'objet de type entreprise
            // $user->setEntreprise($entreprise);
            $user->setUsername($values->username);
            $user->setPassword($passwordEncoder->encodePassword($user, $values->password));
            $user->setNom($values->nom);
            $user->setPrenom($values->prenom);
            $user->setEmail($values->email);
            $user->setTelephone($values->telephone);
            $user->setNci($values->nci);
            $user->setRoles(["ROLE_ADMIN"]);
            $user->setStatus("actif");
            $entityManager->persist($user);
            $entityManager->flush();

            $data = [
                'status' => 201,
                'message' => 'L\'utilisateur a été créé'
            ];

            return new JsonResponse($data, 201);
        }
        $data = [
            'status' => 500,
            'message' => 'Vous devez renseigner les clés username et password'
        ];
        return new JsonResponse($data, 500);
    }

     /**
     * @Route("/login_check", name="login", methods={"POST"})
     */
    public function login(Request $request)
    {
        $user = $this->getUser();
        return $this->json([
            'username' => $user->getUsername(),
            'roles' => $user->getRoles()
        ]);
    }
}
