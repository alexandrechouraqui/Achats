<?php
/**
* TCPDF Bridge 
*
* @author ioalessio
*/
namespace Io\TcpdfBundle\Helper;
use Symfony\Component\HttpFoundation\Response;

class Tcpdf extends \TCPDF{
    //Page header
    public function Header() {
        // Logo
        $image_file = \K_PATH_IMAGES.'header_logo.jpg';
        $this->Image($image_file, 10, 10, 50, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    }
    
    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Crossknowledge - 4, rue du port aux vins 92150 Suresnes France - Tel : +(33) 1 41 38 14 99 - Fax : +(33) 1 41 38 14 39', 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

    public function init()
    {
        // set document information
        $this->SetCreator(PDF_CREATOR);
        $this->SetAuthor('Crossknowledge');
        $this->SetTitle('Purchase Order');
        $this->SetSubject('Purchase order');
        $this->SetKeywords('PDF, Crossknowledge');

        //Header & Footer
        $this->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        
        
        // remove default header/footer
        //$this->setPrintHeader(false);
       // $this->setPrintFooter(false);

        // set default monospaced font
        $this->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        //set margins
        $this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $this->SetHeaderMargin(PDF_MARGIN_HEADER);
        $this->SetFooterMargin(PDF_MARGIN_FOOTER);
        

        //set auto page breaks
        $this->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        //set image scale factor
        $this->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // ---------------------------------------------------------

        // set default font subsetting mode
        $this->setFontSubsetting(true);

        // Set font
        // dejavusans is a UTF-8 Unicode font, if you only need to
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
        $this->SetFont('helvetica', '', 11, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $this->AddPage();

    }
    /**
     */
    public function quick_pdf($html, $file = "html.pdf", $format = "S")
    {
      $this->init();

        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $this->writeHTML($html, true, false, true, false, '');

        $response =  new Response($this->Output($file, $format));
        $response->headers->set('Content-Type', 'application/pdf');
        return $response;

    }
}