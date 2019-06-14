<?php

namespace App\Controller;

use App\Entity\Contractor;
use App\Form\ContractorFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContractorController extends Controller
{
    public function list(): Response
    {
        $contractorRepository = $this->getDoctrine()->getManager()->getRepository(Contractor::class);

        return $this->render('controller/contractor/list.html.twig', [
            'contractors' => $contractorRepository->findBy(['user' => $this->getUser(), 'status' => true]),
        ]);
    }

    public function create(Request $request): Response
    {
        $contractor = new Contractor();
        $form = $this->createForm(ContractorFormType::class, $contractor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contractorRepository = $this->getDoctrine()->getManager()->getRepository(Contractor::class);

            if ($contractorRepository->createFromForm($form, $this->getUser())) {
                $this->getServiceLocator()->getNotifyService()->addSuccess(
                    $this->getServiceLocator()->getTranslator()->trans('contractor.create.success')
                );

                return $this->redirectToRoute('contractor-list');
            }
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $this->getServiceLocator()->getNotifyService()->addFormErrors($form->getErrors(true));
        }

        return $this->render('controller/contractor/create.html.twig', [
            'contractorForm' => $form->createView()
        ]);
    }

    public function edit(int $idContractor, Request $request): Response
    {
        $contractorRepository = $this->getDoctrine()->getManager()->getRepository(Contractor::class);
        $contractor = $contractorRepository->find($idContractor);

        if (!$contractor) {
            $this->getServiceLocator()->getNotifyService()->addError(
                $this->getServiceLocator()->getTranslator()->trans('contractor.edit.notFound')
            );

            return $this->redirectToRoute('contractor-list');
        }

        $form = $this->createForm(ContractorFormType::class, $contractor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contractorRepository = $this->getDoctrine()->getManager()->getRepository(Contractor::class);

            if ($contractorRepository->editFromForm($form, $contractor, $this->getUser())) {
                $this->getServiceLocator()->getNotifyService()->addSuccess(
                    $this->getServiceLocator()->getTranslator()->trans('contractor.edit.success')
                );

                return $this->redirectToRoute('contractor-list');
            }
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $this->getServiceLocator()->getNotifyService()->addFormErrors($form->getErrors(true));
        }

        return $this->render('controller/contractor/edit.html.twig', [
            'contractorForm' => $form->createView()
        ]);
    }

    public function changeStatus(int $idContractor): Response
    {
        $contractorRepository = $this->getDoctrine()->getManager()->getRepository(Contractor::class);
        $contractor = $contractorRepository->find($idContractor);

        if (!$contractor) {
            $this->getServiceLocator()->getNotifyService()->addError(
                $this->getServiceLocator()->getTranslator()->trans('contractor.status.change.notFound')
            );

            return $this->redirectToRoute('contractor-list');
        }

        if ($contractorRepository->changeStatus($contractor)) {
            $this->getServiceLocator()->getNotifyService()->addSuccess(
                $this->getServiceLocator()->getTranslator()->trans('contractor.status.change.success')
            );
        }

        return $this->redirectToRoute('contractor-list');
    }
}