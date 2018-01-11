<?php
namespace app\components\FPDF;

use app\components\FPDF\FPDF;

class PDF extends FPDF
{
    public $headerText = "Titulo";
    function Header()
    {
     // Select Arial bold 15
        $this->SetFont('Arial', 'B', 70);
     // Move to the right
        $this->Ln(20);
     // Framed title
        $this->Cell(0, 0, $this->headerText, 0, 0, 'C');
     // Line break
        $this->Ln(20);
    }
}