<?php

namespace App\Controller;

use App\Service\DocumentService\Document\Invoice;

class InvoiceController extends Controller
{
    public function generateInvoice()
    {
        $invoice = $this->getServiceLocator()->getDocumentService()->getDocument(Invoice::class);
        $invoice->save();
    }
}