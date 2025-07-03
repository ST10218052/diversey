<?php
require('fpdf.php'); // Include the FPDF library

// Define a function to generate the PDF
function createBankDetailsPDF() {
    $pdf = new FPDF();
    $pdf->AddPage();

    // Set title and font
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Bank Details for EFT Payment', 0, 1, 'C');
    $pdf->Ln(10); // Line break

    // Add bank details
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(50, 10, 'Bank Name:', 0, 0);
    $pdf->Cell(0, 10, 'Your Bank Name', 0, 1);

    $pdf->Cell(50, 10, 'Account Number:', 0, 0);
    $pdf->Cell(0, 10, '123456789', 0, 1);

    $pdf->Cell(50, 10, 'Branch Code:', 0, 0);
    $pdf->Cell(0, 10, '12345', 0, 1);

    $pdf->Cell(50, 10, 'Account Type:', 0, 0);
    $pdf->Cell(0, 10, 'Current', 0, 1);

    $pdf->Cell(50, 10, 'Reference:', 0, 0);
    $pdf->Cell(0, 10, 'Your Order ID', 0, 1);

    $pdf->Ln(10);
    $pdf->Cell(0, 10, 'Please use the Order ID as the payment reference.', 0, 1);

    // Output PDF to browser for download
    $pdf->Output('D', 'Bank_Details.pdf');
}

// Generate the PDF
createBankDetailsPDF();
?>
