<!DOCTYPE html>
<html>
<head>
<link href="login/css/bootstrap.css" rel="stylesheet" media="screen">
<script src="includes/jquery.min.js"></script>
    <title>QR Code</title>
    
</head>
<body>

<div>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php">Calico</a>
    </div>
    <a href="login/login/logout.php" class="btn btn-link pull-right" style=" padding-top: 10px; ">Logout</a>
  </div>
</nav>

</div>

<?php    

include_once('includes/Db.php');
include_once('mpdf60/mpdf.php');

$currentCTNid = $_GET['ctnid'];


$db = new Db();
$packageDetails = $db -> getSingleProductDetails($currentCTNid);

    $_REQUEST['data'] = $packageDetails[0]['barcode'].'#'.$packageDetails[0]["ctn"]
                        .'#'.$packageDetails[0]["pi"].'#'.$packageDetails[0]["im"]
                        .'#'.$packageDetails[0]["po"].'#'.$packageDetails[0]["color"];


$Messageg = '<div id="loadprintin">

<style>

table, td, th {
    border: 1px solid black;
    padding: 2px;

}
table
{
    width:100%;
}
hr{
    margin:0;pi
PI
ctn
pi
}


</style>

        

                <table>
  <tr>
    <th><h3>Calico (PVT) LTD</h3></th>
    <th>CTN</th>

  </tr>
  <tr>
    <td>PI Number : '.$packageDetails[0]["ctn"].'
                                    <hr/><br/> IM Number:'.$packageDetails[0]["pi"].'
                                    <hr/><br/> PO Number: '.$packageDetails[0]["im"].'
                                    <hr/><br/> Color Code: '.$packageDetails[0]["po"].'
                                    <hr/><br/> Style ID: '.$packageDetails[0]["color"].'
                                    <hr/><br/> Style ID: '.$packageDetails[0]["style"].'
                                    <hr/><br/> Length: '.$packageDetails[0]["length"].'
                                    <hr/><br/> Quantity: '.$packageDetails[0]["qty"].'
                                    <hr/><br/> Total: '.$packageDetails[0]["total"].'
                                    <hr/><br/> Nett: '.$packageDetails[0]["nett"].'
                                    <hr/><br/> Gross: '.$packageDetails[0]["gross"].'
                                    <hr/><br/> QRcode: '.$packageDetails[0]["barcode"].' </td>
    <td><img src="temp/'.$_GET['filename'].'.png" /></td>

  </tr>

</table>
    
    </div>';



if ($_POST['downloadPDF']) {

    
 
    $mpdf = new mPDF();
    $mpdf = new mPDF('utf-8', 'A6-L');
    $mpdf->SetHTMLFooter('<div style="color: #cccccc; text-align:right; font-size:12px;"> Solution by : surplusdev.com </div>'); 
    $mpdf->WriteHTML($Messageg);
    $mpdf->Output();

}


    if (!$_SESSION["isloggedin"]) {
     //  header( "Location: login.php" );im
    }
    echo "<h2></h1>";
    
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

</body>

<!DOCTYPE html>
<html>
<head>
    <title> QR code</title>

    <script src="includes/jquery.min.js"></script>
      <script type='application/javascript'>
              function printQRCode(){
                    var mywindow = window.open('', 'PRINT', 'height=400,width=700');
                    mywindow.document.write('<html><head><title></title>');
                    mywindow.document.write('<style> @page { size: auto;    margin: 0mm;  }</style>');
                    mywindow.document.write('</head><body >');
                    mywindow.document.write(document.getElementById("loadprintin").innerHTML);
                    mywindow.document.write('<div style="color: #cccccc; text-align:right; font-size:12px;"> Solution by : surplusdev.com </div>');
                    mywindow.document.write('</body></html>');

                    mywindow.document.close(); // necessary for IE >= 10
                    mywindow.focus(); // necessary for IE >= 10*/

                    setTimeout(function(){
                            mywindow.print();
                            mywindow.close();
                        }, 500);

                    return true;
              }
      </script>
</head>
<body>

<div id="barcode_container">



<div class="col-lg-8">
 <table class="table table-bordered table-hover">
 
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

        <div class="col-lg-4"><img style=" display: block; margin: auto; " id="qrcode_image" src="<?php echo 'http://178.62.43.112/1phpqrcode/'.$PNG_WEB_DIR.basename($filename); ?>"/>  
        </div>



        <div id="loadprintin">
                <style>
                table, td, th {
                    border: 1px solid black;
                    padding: 2px;
                    }
                table { width:100%;}
                hr{ margin:0; }
                </style>

                        
                <table>
                      <tr>
                        <th style="width: 80%"><h3>Calico (PVT) LTD</h3></th>
                        <th>CTN</th>

                      </tr>
                      <tr>
                            <td>CTN Number : <?php echo $packageDetails[0]["ctn"]; ?>
                        <hr/><br/> PI Number:<?php echo $packageDetails[0]["pi"]; ?>
                        <hr/><br/> PO Number: <?php echo $packageDetails[0]["im"]; ?>
                        <hr/><br/> Color Code: <?php echo $packageDetails[0]["po"]; ?>
                        <hr/><br/> Style ID: <?php echo $packageDetails[0]["color"]; ?>
                        <hr/><br/> Length: <?php echo $packageDetails[0]["length"]; ?>
                        <hr/><br/> Nett: <?php echo $packageDetails[0]["nett"]; ?>
                        <hr/><br/> Gross: <?php echo $packageDetails[0]["gross"]; ?>
                        <hr/><br/> QRcode: <?php echo $packageDetails[0]["barcode"]; ?> </td>
                        <td><img style=" display: block; margin: auto; " id="qrcode_image" src="<?php echo 'http://178.62.43.112/1phpqrcode/'.$PNG_WEB_DIR.basename($filename); ?>"/></td>
                      </tr>
                </table>
        </div>

</div>

<div style=" display: block; margin: auto; text-align: center;">
   <input class="btn btn-default" type="submit" onclick="printQRCode()" value="PRINT">
   <form style=" display: inline-block; " action="qrcodegenerator.php?ctnid=<?php echo $currentCTNid; ?>
                &filename=<?php echo 'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize); ?>" method="POST"> <input type="submit" class="btn btn-default" name="downloadPDF" value="Print To PDF">
    </form>
 </div>


<script type="text/javascript">
        document.getElementById("loadprintin").hidden=true;               
</script>

</body>
</html>