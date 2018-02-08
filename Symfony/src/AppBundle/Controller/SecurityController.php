<?php
/**
 * Created by PhpStorm.
 * User: or_os
 * Date: 21.11.2017
 * Time: 17:26
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;





class SecurityController extends Controller
{

    /**
     * @Route("/login", name="user_login")
     * @Template()
     */
    public function loginAction(Request $request, AuthenticationUtils $authUtils)
    {

        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();
        dump(session_id());
        return ['last_username' => $lastUsername, 'error' => $error];
    }

    private function Session (){
        session_start();

    }


    /**
     * @Route("/registration", name="user_registration")
     * @Template()
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // 1) build the form
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('homepage');
        }

        return ['form' => $form->createView()];

    }

    /**
     * @Route("/logout", name="security_logout")
     * @Template()
     */
    public function logoutAction()
    {
               return [];
    }
    /**
     * @Route("/session_close", name="security_session_close")
     * @Template()
     */
    public function logoutSessionAction()
    {
        $repo = $this->get('doctrine')->getRepository('AppBundle:Session');
        $repo->DeleteById(session_id());
        return $this->redirectToRoute('security_logout');
    }



}