<?php

namespace App\Controller;

class InvoiceController extends Controller
{
    public function generateInvoice()
    {
        $this->getServiceLocator()->getInvoiceService()->generateInvoice();
    }
}