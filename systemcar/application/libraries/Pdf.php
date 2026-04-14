<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once('./dompdf/autoload.inc.php');

use Dompdf\Adapter\CPDF;
use Dompdf\Dompdf;
use Dompdf\Exception;

class Pdf {

    function createPDF($html, $filename = '', $download = TRUE, $paper = 'A6', $orientation = 'portrait') {
        $dompdf = new Dompdf();

        // Forzar Dompdf a usar DejaVu Sans para soporte multilenguaje (ruso, etc)
        // Si el HTML no tiene la fuente, la agregamos aquí
        $html = preg_replace(
            '/<head>/i',
            '<head><style>body, h5 { font-family: DejaVu Sans, sans-serif !important; }</style>',
            $html
        );

        $dompdf->load_html($html);
        $dompdf->set_paper($paper, $orientation);

        // Opcional: Habilitar fuentes externas y Unicode
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->set_option('isUnicode', true);

        $dompdf->render();
        if ($download)
            $dompdf->stream($filename . '.pdf', array('Attachment' => 1));
        else
            $dompdf->stream($filename . '.pdf', array('Attachment' => 0));
    }

}

?>