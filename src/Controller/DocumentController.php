<?php

namespace App\Controller;

use App\Entity\Contractor;
use App\Entity\Document;
use App\Entity\DocumentType;
use App\Entity\PaymentMethod;
use App\Form\DocumentFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DocumentController extends Controller
{
    public function create(Request $request): Response
    {
        $document = new Document();
        $contractorRepository = $this->getDoctrine()->getRepository(Contractor::class);
        $documentTypeRepository = $this->getDoctrine()->getRepository(DocumentType::class);
        $paymentMethodRepository = $this->getDoctrine()->getRepository(PaymentMethod::class);

        $form = $this->createForm(DocumentFormType::class, $document, [
            'data' => [
                'contractors' => $contractorRepository->getAllToForm(),
                'documentTypes' => $documentTypeRepository->getAllToForm(),
                'paymentMethods' => $paymentMethodRepository->getAllToForm(),
            ]
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            dump($form->getNormData());
            exit(';)');
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $this->getServiceLocator()->getNotifyService()->addFormErrors($form->getErrors(true));
        }

        return $this->render('controller/document/create.html.twig', [
            'documentForm' => $form->createView()
        ]);
    }
}