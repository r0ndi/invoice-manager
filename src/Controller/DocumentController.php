<?php

namespace App\Controller;

use App\Util\Money;
use App\Entity\Tax;
use App\Entity\Document;
use App\Util\PriceCalculator;
use App\Form\DocumentFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\DocumentService\Document\Invoice;

class DocumentController extends Controller
{
    public function list(): Response
    {
        $documentRepository = $this->getDoctrine()->getManager()->getRepository(Document::class);
        $documents = $documentRepository->findBy(['user' => $this->getUser(), 'status' => true], ['id' => 'desc']);

        return $this->render('controller/document/list.html.twig', [
            'documents' => $documents
        ]);
    }

    public function create(Request $request): Response
    {
        $document = new Document();
        $form = $this->createForm(DocumentFormType::class, $document, [
            'data' => $this->getFormData($document)
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $documentRepository = $this->getDoctrine()->getManager()->getRepository(Document::class);

            if ($documentRepository->createFromForm($form, $this->getUser())) {
                $documentService = $this->getServiceLocator()->getDocumentService();

                if ($documentService->getDocument(Invoice::class, $document)->save()) {
                    $this->getServiceLocator()->getNotifyService()->addSuccess(
                        $this->getServiceLocator()->getTranslator()->trans('document.create.success')
                    );

                    return $this->redirectToRoute('document-list');
                }
            }
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $this->getServiceLocator()->getNotifyService()->addFormErrors($form->getErrors(true));
        }

        return $this->render('controller/document/create.html.twig', [
            'documentForm' => $form->createView()
        ]);
    }

    public function edit(int $idDocument, Request $request): Response
    {
        $document = $this->getDocument($idDocument);

        if (!$document) {
            return $this->redirectToRoute('document-list');
        }

        $form = $this->createForm(DocumentFormType::class, $document, [
            'data' => $this->getFormData($document)
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $documentRepository = $this->getDoctrine()->getManager()->getRepository(Document::class);

            if ($documentRepository->editFromForm($form, $document, $this->getUser())) {
                $documentService = $this->getServiceLocator()->getDocumentService();
                $documentService->getDocument(Invoice::class, $document)->remove();

                if ($documentService->getDocument(Invoice::class, $document)->save()) {
                    $this->getServiceLocator()->getNotifyService()->addSuccess(
                        $this->getServiceLocator()->getTranslator()->trans('document.edit.success')
                    );

                    return $this->redirectToRoute('document-list');
                }
            }
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $this->getServiceLocator()->getNotifyService()->addFormErrors($form->getErrors(true));
        }

        return $this->render('controller/document/edit.html.twig', [
            'documentForm' => $form->createView()
        ]);
    }

    public function delete(int $idDocument): Response
    {
        $documentRepository = $this->getDoctrine()->getManager()->getRepository(Document::class);
        $document = $this->getDocument($idDocument);

        if (!$document) {
            return $this->redirectToRoute('document-list');
        }

        if ($documentRepository->changeStatus($document)) {
            $documentService = $this->getServiceLocator()->getDocumentService()->getDocument(Invoice::class, $document);

            if ($documentService->remove()) {
                $this->getServiceLocator()->getNotifyService()->addSuccess(
                    $this->getServiceLocator()->getTranslator()->trans('document.delete.success')
                );
            }
        }

        return $this->redirectToRoute('document-list');
    }

    public function download(int $idDocument): Response
    {
        $document = $this->getDocument($idDocument);

        if (!$document) {
            return $this->redirectToRoute('document-list');
        }

        $documentService = $this->getServiceLocator()->getDocumentService()->getDocument(Invoice::class, $document);
        $documentService->download();
        exit;
    }

    public function preview(int $idDocument): Response
    {
        $document = $this->getDocument($idDocument);

        if (!$document) {
            return $this->redirectToRoute('document-list');
        }

        $documentService = $this->getServiceLocator()->getDocumentService()->getDocument(Invoice::class, $document);
        $documentService->preview();
        exit;
    }

    public function refreshPrices(Request $request): void
    {
        $netPrice = (float)str_replace([',', '.', ' ', 'zl', 'zł'], '', $request->request->get('netPrice'));
        $quantity = (int)$request->request->get('quantity');
        $idTax = (int)$request->request->get('tax');

        $tax = $this->getDoctrine()->getManager()->find(Tax::class, $idTax);
        if (!($tax instanceof Tax)) {
            exit;
        }

        $priceCalculator = new PriceCalculator($netPrice, $tax, $quantity);

        $response = [
            'net' => Money::format($priceCalculator->getNet()),
            'netValue' => Money::format($priceCalculator->getNetValue()),
            'gross' => Money::format($priceCalculator->getGross()),
            'grossValue' => Money::format($priceCalculator->getGrossValue()),
            'tax' => Money::format($priceCalculator->getTax()),
            'taxValue' => Money::format($priceCalculator->getTaxValue()),
        ];

        exit(json_encode($response));
    }

    private function getDocument(int $idDocument): ?Document
    {
        $documentRepository = $this->getDoctrine()->getManager()->getRepository(Document::class);
        $document = $documentRepository->find($idDocument);

        if ($document instanceof Document) {
            return $document;
        }

        $this->getServiceLocator()->getNotifyService()->addError(
            $this->getServiceLocator()->getTranslator()->trans('document.notFound')
        );

        return null;
    }

    private function getFormData(Document $document): array
    {
        return [
            'document' => $document,
            'user' => $this->getUser(),
            'doctrine' => $this->getDoctrine()
        ];
    }
}