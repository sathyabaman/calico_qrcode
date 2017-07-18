<?php

include_once('Db.php');
include_once('../mpdf60/mpdf.php');


    $mpdf = new mPDF();
    $mpdf = new mPDF('utf-8', 'A6-L');

    $mpdf->Bookmark('Start of the document');

	$mpdf->SetHTMLHeader('<div> <img src="assets/img/pdf_header.png"/></div>'); 
	// PDF footer content                      
	$mpdf->SetHTMLFooter('<div> <a href="http://www.surplus.dev">www.surplus.dev</a> </div>'); 

    $mpdf->WriteHTML('<div> <img src="assets/img/pdf_header.png"/></div>' );

   // $mpdf->Output();
    $mpdf->Output('MyPDF.pdf', 'D');



?>