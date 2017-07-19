<?php    

include_once('includes/Db.php');
include_once('mpdf60/mpdf.php');

$currentCTNid = $_GET['ctnid'];


$db = new Db();
$packageDetails = $db -> getSingleProductDetails($currentCTNid);

    $_REQUEST['data'] = $packageDetails[0]['barcode'];


$Messageg = '<div> <img  style="float: right" src="temp/'.$_GET['filename'].'.png" /></div>

                 <table>
                    <colgroup>
                        <col class="col1" />
                        <col class="col2" />
                    </colgroup>
                    <tbody>

                        <THEAD style="background: orange;">
                            <tr>
                                <td>Description</td>
                                <td>Value</td>
                            </tr>
                        </THEAD>
                        <tr>
                            <td><label >CTN Number: </label></td>
                            <td>'.$packageDetails[0]["ctn"].'</td>
                        </tr>
                    
                     <tr>
                            <td><label >PI Number</label></td>
                            <td>'.$packageDetails[0]["pi"].'</td>
                        </tr>

                        <tr>
                            <td><label >IM Number: </label></td>
                            <td>'.$packageDetails[0]["im"].'</td>
                        </tr>
                        <tr>
                            <td><label >PO Number: </label></td>
                            <td>'.$packageDetails[0]["po"].'</td>
                        </tr>

                        <tr>
                            <td><label >Color Code</label></td>
                            <td>'.$packageDetails[0]["color"].'</td>
                        </tr>

                        <tr>
                            <td><label >Style ID: </label></td>
                            <td>'.$packageDetails[0]["style"].'</td>
                        </tr>
                        <tr>
                            <td><label >Length</label></td>
                            <td>'.$packageDetails[0]["length"].'</td>
                        </tr>

                        <tr>
                            <td><label >Quantity: </label></td>
                            <td>'.$packageDetails[0]["qty"].'</td>
                        </tr>
                        <tr>
                            <td><label >Total</label></td>
                            <td>'.$packageDetails[0]["total"].'</td>
                        </tr>

                        <tr>
                            <td><label >NETT </label></td>
                            <td>'.$packageDetails[0]["nett"].'</td>
                        </tr>
                        <tr>
                            <td><label >Gross</label></td>
                            <td>'.$packageDetails[0]["gross"].'</td>
                        </tr>
                
                        <tr>
                            <td><label for="text">QRcode Data</label></td>
                            <td>'.$packageDetails[0]["barcode"].'</td>
                        </tr>
                    
                    </tbody>
                </table>
    ';



if ($_POST['downloadPDF']) {

    
 
    $mpdf = new mPDF();
    $mpdf = new mPDF('utf-8', 'A6-L');
    $mpdf->SetHTMLHeader('<div> <img src="images/Calico_logo.jpg" style="height:50px, width: 150px"/></div>'); 
    $mpdf->SetHTMLFooter('<div> <a href="http://www.surplus.dev">www.surplus.dev</a> </div>'); 
    $mpdf->WriteHTML($Messageg);
    $mpdf->Output();

}


    if (!$_SESSION["isloggedin"]) {
     //  header( "Location: login.php" );
    }
    echo "<h1>Surplus QR code</h1><hr/>";
    
    //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';

    include "qrlib.php";    
    
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    
    
    $filename = $PNG_TEMP_DIR.'test.png';
    
    //processing form input
    //remember to sanitize user input in real-life solution !!!
    $errorCorrectionLevel = 'L';
    if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
        $errorCorrectionLevel = $_REQUEST['level'];    

    $matrixPointSize = 7;
    if (isset($_REQUEST['size']))
        $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);


    if (isset($_REQUEST['data'])) { 
    
        //it's very important!
        if (trim($_REQUEST['data']) == '')
            die('data cannot be empty! <a href="?">back</a>');
            
        // user data
        $filename = $PNG_TEMP_DIR.'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        
    }   
 


?>


<!DOCTYPE html>
<html>
<head>
    <title>surplus QR code</title>

    <script src="includes/jquery.min.js"></script>
      <script type='application/javascript'>
              function printQRCode(){
                    var mywindow = window.open('', 'PRINT', 'height=400,width=600');
                    mywindow.document.write('<html><head><title>Surplus QRcode </title>');
                    mywindow.document.write('</head><body >');
                    mywindow.document.write('<h1>' + document.title  + '</h1>');
                    console.log(document.getElementById("barcode_container").innerHTML);
                    mywindow.document.write(document.getElementById("barcode_container").innerHTML);
                    mywindow.document.write('</body></html>');

                    mywindow.document.close(); // necessary for IE >= 10
                    mywindow.focus(); // necessary for IE >= 10*/

                    setTimeout(function(){
                            mywindow.print();
                            mywindow.close();
                        }, 1000);

                    return true;
              }
      </script>
</head>
<body>

<div id="barcode_container">

 <table>
 <img id="qrcode_image" src="<?php echo 'http://localhost/phpqrcode/'.$PNG_WEB_DIR.basename($filename); ?>"/><hr/>  
                <colgroup>
                    <col class="col1" />
                    <col class="col2" />
                </colgroup>
                <tbody>

                    <THEAD style="background: orange;">
                        <tr>
                            <td>Description</td>
                            <td>Value</td>
                        </tr>
                    </THEAD>
                    <tr>
                        <td><label >CTN Number: </label></td>
                        <td><?php echo $packageDetails[0]['ctn']; ?></td>
                    </tr>
                    <tr>
                        <td><label >PI Number</label></td>
                        <td><?php echo $packageDetails[0]['pi']; ?></td>
                    </tr>

                    <tr>
                        <td><label >IM Number: </label></td>
                        <td><?php echo $packageDetails[0]['im']; ?></td>
                    </tr>
                    <tr>
                        <td><label >PO Number: </label></td>
                        <td><?php echo $packageDetails[0]['po']; ?></td>
                    </tr>

                    <tr>
                        <td><label >Color Code</label></td>
                        <td><?php echo $packageDetails[0]['color']; ?></td>
                    </tr>

                    <tr>
                        <td><label >Style ID: </label></td>
                        <td><?php echo $packageDetails[0]['style']; ?></td>
                    </tr>
                    <tr>
                        <td><label >Length</label></td>
                        <td><?php echo $packageDetails[0]['length']; ?></td>
                    </tr>

                    <tr>
                        <td><label >Quantity: </label></td>
                        <td><?php echo $packageDetails[0]['qty']; ?></td>
                    </tr>
                    <tr>
                        <td><label >Total</label></td>
                        <td><?php echo $packageDetails[0]['total']; ?></td>
                    </tr>

                    <tr>
                        <td><label >NETT </label></td>
                        <td><?php echo $packageDetails[0]['nett']; ?></td>
                    </tr>
                    <tr>
                        <td><label >Gross</label></td>
                        <td><?php echo $packageDetails[0]['gross']; ?></td>
                    </tr>
            
                    <tr>
                        <td><label for="text">Barcode Data</label></td>
                        <td><?php echo $packageDetails[0]['barcode']; ?></td>
                    </tr>

                </tbody>
               
            </table>
    </div>

    <hr/>
   <input type="submit" onclick="printQRCode()" value="PRINT">
   <form action="qrcodegenerator.php?ctnid=<?php echo $currentCTNid; ?>
                &filename=<?php echo 'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize); ?>" method="POST"> <input type="submit" name="downloadPDF" value="Print To PDF">
                </form>
  <hr/>


</body>
</html>