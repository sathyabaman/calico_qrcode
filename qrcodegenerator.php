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
    
  </div>
</nav>

</div>

<?php    

//include_once('includes/Db.php');
include_once('mpdf60/mpdf.php');

$currentCTNid = $_GET['str'];


$ProductData = explode("@@",$currentCTNid);
$packageDetails = explode("@@",$_GET['str']);

//$db = new Db();
//$packageDetails = $db -> getSingleProductDetails($currentCTNid);

$_REQUEST['data'] = $currentCTNid;;



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
                                    <td>PI Number : '. $packageDetails[0].'
                                    <hr/><br/> IM Number:'.$packageDetails[1].'
                                    <hr/><br/> PO Number: '.$packageDetails[2].'
                                    <hr/><br/> Color Code: '.$packageDetails[3].'
                                    <hr/><br/> Style ID: '.$packageDetails[4].'
                                    <hr/><br/> Style ID: '.$packageDetails[5].'
                                    <hr/><br/> Length: '.$packageDetails[6].'
                                    <hr/><br/> Quantity: '.$packageDetails[7].'
                                    <hr/><br/> Total: '.$packageDetails[8].' </td>
    <td><img src="temp/'.$_GET['filename'].'.png" /></td>
  </tr>
</table>
    
    </div>';


if ($_POST['downloadPDF']) {

   
    $mpdf = new mPDF();
    $mpdf = new mPDF('utf-8', 'A6-L');
    $mpdf->SetHTMLFooter('<div style=" color: #000000; text-align:right; font-size:12px;"> Solution by : surplusdev.com </div>'); 
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
                    mywindow.document.write('<div style="text-align:right; font-size:12px;color:black !important;"> Solution by : surplusdev.com </div>');
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
                        <td><label >Vendor Number: </label></td>
                        <td><?php echo $ProductData[0]; ?></td>
                    </tr>
                    <tr>
                        <td><label >PI Number</label></td>
                        <td><?php echo $ProductData[1]; ?></td>
                    </tr>

                    <tr>
                        <td><label >Invoice Number: </label></td>
                        <td><?php echo $ProductData[2]; ?></td>
                    </tr>
                    <tr>
                        <td><label >Color: </label></td>
                        <td><?php echo $ProductData[3]; ?></td>
                    </tr>

                    <tr>
                        <td><label >Style Number: </label></td>
                        <td><?php echo $ProductData[4]; ?></td>
                    </tr>
                    <tr>
                        <td><label >GT</label></td>
                        <td><?php echo $ProductData[5]; ?></td>
                    </tr>

                    <tr>
                        <td><label >Quantity: </label></td>
                        <td><?php echo $ProductData[6]; ?></td>
                    </tr>
            
                    <tr>
                        <td><label >NETT </label></td>
                        <td><?php echo $ProductData[7]; ?></td>
                    </tr>
                    <tr>
                        <td><label >Gross</label></td>
                        <td><?php echo $ProductData[8]; ?></td>
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
                    padding: 1.5px;
                    }
                table { width:100%;}
                hr{ margin:0; }
                </style>

                        
                <table>
                      <tr>
                        <th style="width: 80%"><img style="display:inline;" src="images/calico.GIF" alt="calico" height="42" width="42"><h1 style="display:inline;position:relative;bottom:15px; left:5px">CALICO (PVT) LTD</h1></th>
                        <th style="font-size:2em"><h2><?php echo $ProductData[0]; ?></h2></th>

                      </tr>
                      <tr>
                            <td><strong> Vendor Number : <?php echo $ProductData[1]; ?> </strong>
                        <hr/><br/> <strong> PI Number:<?php echo $ProductData[2]; ?> </strong>
                        <hr/><br/> <strong> Invoice Number: <?php echo $ProductData[3]; ?> </strong>
                        <hr/><br/> <strong> Color : <?php echo $ProductData[4]; ?> </strong>
                        <hr/><br/> <strong> Style Number: <?php echo $ProductData[5]; ?> </strong>
                        <hr/><br/> <strong> GT: <?php echo $ProductData[6]; ?> </strong>
                        <hr/><br/> <strong> Quantity: <?php echo $ProductData[7]; ?> </strong>
                        <hr/><br/> <strong> Net : <?php echo $ProductData[8]; ?> </strong>
                        <hr/><br/> <strong> Gross: <?php echo $ProductData[9]; ?> </strong> </td>
                        <td><img style=" display: block; margin: auto; " id="qrcode_image" src="<?php echo 'http://178.62.43.112/1phpqrcode/'.$PNG_WEB_DIR.basename($filename); ?>"/></td>
                      </tr>
                </table>
        </div>

</div>

<div style=" display: block; margin: auto; text-align: center;">
   <input class="btn btn-default" type="submit" onclick="printQRCode()" value="PRINT">
<!--    <form style=" display: inline-block; " action="qrcodegenerator.php?ctnid=<?php echo $currentCTNid; ?>
                &filename=<?php echo 'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize); ?>" method="POST"> <input type="submit" class="btn btn-default" name="downloadPDF" value="Print To PDF">
    </form> -->
 </div>


<script type="text/javascript">
        document.getElementById("loadprintin").hidden=true;               
</script>

</body>
</html>