<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LogoFormType;
use App\Form\PasswordFormType;
use App\Form\UserFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends Controller
{
    public function edit(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = $this->getUser();
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $userForm = $this->createForm(UserFormType::class, $user, ['data' => ['doctrine' => $this->getDoctrine(), 'user' => $user]]);
        $passwordForm = $this->createForm(PasswordFormType::class);
        $logoForm = $this->createForm(LogoFormType::class);

        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            if ($userRepository->editAccountInfoFromForm($userForm, $user)) {
                $this->getServiceLocator()->getNotifyService()->addSuccess(
                    $this->getServiceLocator()->getTranslator()->trans('user.edit.success')
                );

                return $this->redirect($this->generateUrl('user-edit'));
            }

            $this->getServiceLocator()->getNotifyService()->addError(
                $this->getServiceLocator()->getTranslator()->trans('user.edit.fail')
            );
        }

        $passwordForm->handleRequest($request);
        if ($passwordForm->isSubmitted() && $passwordForm->isValid()) {
            if ($userRepository->resetPassword($passwordForm, $user, $passwordEncoder)) {
                $this->getServiceLocator()->getNotifyService()->addSuccess(
                    $this->getServiceLocator()->getTranslator()->trans('user.edit.success')
                );

                return $this->redirect($this->generateUrl('user-edit'));
            }

            $this->getServiceLocator()->getNotifyService()->addError(
                $this->getServiceLocator()->getTranslator()->trans('user.edit.fail')
            );
        }

        $logoForm->handleRequest($request);
        if ($logoForm->isSubmitted() && $logoForm->isValid()) {
            if ($userRepository->uploadLogo($logoForm, $user)) {
                $this->getServiceLocator()->getNotifyService()->addSuccess(
                    $this->getServiceLocator()->getTranslator()->trans('user.edit.success')
                );

                return $this->redirect($this->generateUrl('user-edit'));
            }

            $this->getServiceLocator()->getNotifyService()->addError(
                $this->getServiceLocator()->getTranslator()->trans('user.edit.fail')
            );
        }

        if ($logoForm->isSubmitted() && !$logoForm->isValid()) {
            $this->getServiceLocator()->getNotifyService()->addFormErrors($logoForm->getErrors(true));
        }

        return $this->render('controller/user/edit.html.twig', [
            'passwordForm' => $passwordForm->createView(),
            'userForm' => $userForm->createView(),
            'logoForm' => $logoForm->createView(),
        ]);
    }

}