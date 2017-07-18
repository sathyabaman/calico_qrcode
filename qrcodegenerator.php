<?php    

include_once('includes/Db.php');
include_once('mpdf60/mpdf.php');

$currentCTNid = $_GET['ctnid'];


$db = new Db();
$packageDetails = $db -> getSingleProductDetails($currentCTNid);

    $_REQUEST['data'] = $packageDetails[0]['barcode'];


if ($_POST['downloadPDF']) {
    $mpdf = new mPDF();

    $mpdf->Bookmark('Start of the document');

    $mpdf->WriteHTML('<div>
<img src="$PNG_WEB_DIR.basename($filename)"/><hr/>  


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
                        <td>$packageDetails[0]["ctn"]</td>
                    </tr>
                    <tr>
                        <td><label >PI Number</label></td>
                        <td>$packageDetails[0]["pi"] </td>
                    </tr>

                    <tr>
                        <td><label >IM Number: </label></td>
                        <td>$packageDetails[0]["im"] </td>
                    </tr>
                    <tr>
                        <td><label >PO Number: </label></td>
                        <td>$packageDetails[0]["po"] </td>
                    </tr>

                    <tr>
                        <td><label >Color Code</label></td>
                        <td>$packageDetails[0]["color"] </td>
                    </tr>

                    <tr>
                        <td><label >Style ID: </label></td>
                        <td>$packageDetails[0]["style"] </td>
                    </tr>
                    <tr>
                        <td><label >Length</label></td>
                        <td>$packageDetails[0]["length"] </td>
                    </tr>

                    <tr>
                        <td><label >Quantity: </label></td>
                        <td>$packageDetails[0]["qty"] </td>
                    </tr>
                    <tr>
                        <td><label >Total</label></td>
                        <td>$packageDetails[0]["total"] </td>
                    </tr>

                    <tr>
                        <td><label >NETT </label></td>
                        <td>$packageDetails[0]["nett"] </td>
                    </tr>
                    <tr>
                        <td><label >Gross</label></td>
                        <td>$packageDetails[0]["gross"] </td>
                    </tr>
            
                    <tr>
                        <td><label for="text">Barcode Data</label></td>
                        <td>$packageDetails[0]["barcode"] </td>
                    </tr>

                
                </tbody>

               
            </table>
            </div>'


            );

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
        
    } else {    
    
        // //default data
        // echo 'You can provide data in GET parameter: <a href="?data=like_that">like that</a><hr/>';    
        // QRcode::png($packageDetails[0]['barcode'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        
    }    
        
    //display generated file
    
    
    // //config form
    // echo '<form action="index.php" method="post">
    //     Data:&nbsp;<input name="data" value="'.(isset($_REQUEST['data'])?htmlspecialchars($_REQUEST['data']):'PHP QR Code :)').'" />&nbsp;
    //     ECC:&nbsp;<select name="level">
    //         <option value="L"'.(($errorCorrectionLevel=='L')?' selected':'').'>L - smallest</option>
    //         <option value="M"'.(($errorCorrectionLevel=='M')?' selected':'').'>M</option>
    //         <option value="Q"'.(($errorCorrectionLevel=='Q')?' selected':'').'>Q</option>
    //         <option value="H"'.(($errorCorrectionLevel=='H')?' selected':'').'>H - best</option>
    //     </select>&nbsp;
    //     Size:&nbsp;<select name="size">';
        
    // for($i=1;$i<=10;$i++)
    //     echo '<option value="'.$i.'"'.(($matrixPointSize==$i)?' selected':'').'>'.$i.'</option>';

           
        

        
    // benchmark
    //QRtools::timeBenchmark();    


?>


<!DOCTYPE html>
<html>
<head>
    <title>QR code</title>

  <script type='application/javascript'>

  function printQRCode(){
    window.print()

  }

  </script>
</head>
<body>

<div>
<img src="<?php echo $PNG_WEB_DIR.basename($filename); ?>"/><hr/>  


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
   <form action="qrcodegenerator.php?ctnid=<?php echo $currentCTNid; ?>" method="POST"> <input type="submit" name="downloadPDF" value="DOWNLOAD"></form>
  <hr/>


</body>
</html>