<?php
namespace App\Services;

use Barryvdh\DomPDF\Facade as PDF;

class PDFService
{
    public static function generate_pdf_base64($data, $view, $filename = "document.pdf")
    {
        $pdf = PDF::loadHTML(view($view, $data));
        return "data:application/pdf;base64," . base64_encode($pdf->stream($filename));
    }
}
