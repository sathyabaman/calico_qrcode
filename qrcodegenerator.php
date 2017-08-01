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
                  //  mywindow.document.write('<div style="text-align:right; font-size:12px; color:black !important;"> Solution by : surplusdev.com </div>');
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

        <div class="col-lg-4"><img style=" display: block; margin: auto; " id="qrcode_image" src="<?php echo 'http://localhost/phpqrcode/'.$PNG_WEB_DIR.basename($filename); ?>"/>  
        </div>



        <div id="loadprintin">



        <html xmlns="http://www.w3.org/1999/xhtml"><head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Responsive HTML Email Template</title>
        <style type="text/css">

            @font-face {
                font-family: digitaltech;
                src: url(includes/Digital_tech.otf);
            }

            /*Global Styles*/
            body { font-family: digitaltech ; margin: 0; padding: 0; min-width: 100%!important;}
            a { color: #5e96ea; text-decoration: none; font-weight: bold;}
            img {height: auto;}
            .content { border: 1px solid #eeeeee; }
            .logo {font-family: digitaltech; font-size: 30px; font-weight: bold; color: black;}
            .link a {font-family: digitaltech; font-size: 12px; color: #ffffff;}
            .subheading {font-size: 14px; color: #cccccc; font-family: digitaltech; font-weight: bold; padding: 0 0 0 0; text-transform: uppercase; letter-spacing: 1px;}
            .h1 {font-family: digitaltech; font-size: 48px; font-weight: bold; line-height: 56px; color: #ffffff; padding: 0 0 0 0;}
            .h2 {font-family: digitaltech; font-size: 18px; font-weight: bold; color: #444444; padding: 0 0 0 0; text-transform: uppercase; letter-spacing: 0.5px;}
            .h3 {font-family: digitaltech; font-size: 24px; font-weight: regular; color: #555555; padding: 0 0 0 0;}
            .h4 {font-family: digitaltech; font-size: 18px; font-weight: bold; color: #666666; padding: 0 0 0 0;}
            .paragraph {font-family: digitaltech; font-size: 14px; line-height: 22px; color: #666666; font-weight: 200; padding: 20px 0 0 0;}
            .listitem {font-family: digitaltech; font-size: 14px; color: #666666; font-weight: 200; padding: 0 0 20px 0;}
            .listitem-d {font-family: digitaltech; font-size: 25px; color: black; font-weight: 600; padding: 0 0 20px 0;}
            .smalltext { font-family: digitaltech; font-size: 14px; color: #cccccc; padding: 3px 0 0 0; }
            .borderbottom {border-bottom: 1px solid #f2eeed;}
            .num{font-family: digitaltech; font-size: 60px; font-weight: bold; line-height: 56px; color: black  ; padding: 0 0 0 0;}

            
            
            /*Media Queries*/
            @media only screen and (max-width: 651px){
                .columns{width:100% !important;}
                .columncontainer{display:block !important; width:100% !important;}
                .paragraph, .listitem {font-size: 18px;}
                .link { float: left;}
            }
                
            @media only screen and (min-width: 651px) {
                .content {width: 650px !important;}
            }
            
        </style>
    </head>
    <body bgcolor="#f6f6f6">

        <table width="100%" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0">
            <tbody>

            <tr>
                <td>    
                    <!--Content Wrapper-->
                    <table class="content" bgcolor="#ffffff" align="center" cellpadding="0" cellspacing="0" border="0">

                        <tbody>
<tr>
                            <td bgcolor="#f1f1f1" style="padding: 30px 20px 20px 30px;">
                                <table border="0x" cellpadding="0" cellspacing="0" width="100%" class="columns">
                                    <tbody><tr valign="top">
                                        <td width="50%" class="columncontainer">
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                <tbody><tr>
                                                    <td class="logo" >
                                                        <img src="images/calico.GIF" style="width:45px; height:45px;"> <p style="display:inline;position:relative;bottom:15px;"> CALICO PVT LTD</p>
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                        </td>
                                        <td width="50%" valign="middle" class="columncontainer">
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                <tbody><tr>
                                                    <td align="right" valign="middle" >
                                                        <table border="0" cellspacing="0" cellpadding="0" class="link">
                                                            <tbody><tr>
                                                                <td style="padding: 0px 15px 0px 0px;">
                                                                    <p class="num"><?php echo $ProductData[0]; ?></p>
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                        </td>
                                    </tr>
                                </tbody></table>
                            </td>
                        </tr>

                        <tr>
                            <td class="borderbottom" style="padding: 25px 30px 0px 30px;">
                                <table class="data" border="0" cellpadding="0" cellspacing="0" width="620" class="columns">
                                    <tbody><tr valign="top">
                                        <td width="50%" class="columncontainer">
                                            <table border="0" cellspacing="0" cellpadding="0" style="padding: 10px 15px 10px 15px;">
                                                <tbody><tr>
                                                    <td class="listitem" valign="top" style="padding: 0 10px 0 0;">Vendor Name</td>
                                                    <td class="listitem-d"><?php echo $ProductData[1]; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="listitem" valign="top" style="padding: 0 10px 0 0;">PI Number</td>
                                                    <td class="listitem-d"><?php echo $ProductData[2]; ?></td>
                                                    </tr>
                                                </tr>
                                                <tr>
                                                    <td class="listitem" valign="top" style="padding: 0 10px 0 0;">Invoice Number</td>
                                                    <td class="listitem-d"><?php echo $ProductData[3]; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="listitem" valign="top" style="padding: 0 10px 0 0;">Item</td>
                                                    <td class="listitem-d"><?php echo $ProductData[4]; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="listitem" valign="top" style="padding: 0 10px 0 0;">Color</td>
                                                    <td class="listitem-d"><?php echo $ProductData[5]; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="listitem" valign="top" style="padding: 0 10px 0 0;">Style NO</td>
                                                    <td class="listitem-d"> <?php echo $ProductData[6]; ?></td>
                                                </tr>
                                                
                                            </tbody></table>
                                        </td>
                                        <td width="50%" class="columncontainer">
                                            <table border="0" cellspacing="0" cellpadding="0" style="padding: 10px 15px 10px 15px;">
                                                <tbody>
                                                <tr>
                                                    <td class="listitem" valign="top" style="padding: 0 10px 0 0;">GT</td>
                                                    <td class="listitem-d"><?php echo $ProductData[7]; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="listitem" valign="top" style="padding: 0 10px 0 0;">Quantity</td>
                                                    <td class="listitem-d"><?php echo $ProductData[8]; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="listitem" valign="top" style="padding: 0 10px 0 0;">Net</td>
                                                    <td class="listitem-d"><?php echo $ProductData[9]; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="listitem" valign="top" style="padding: 0 10px 0 0;">Gross</td>
                                                    <td class="listitem-d"><?php echo $ProductData[10]; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="listitem" valign="top" style="padding: 0 10px 0 0;">QR</td>
                                                    <td class="listitem"><img style="width: 100px; height: 100px;" src="<?php echo 'http://localhost/phpqrcode/'.$PNG_WEB_DIR.basename($filename); ?>"></td>
                                                </tr>
                                            </tbody></table>
                                        <p style="float: right; font-family: sans-serif;font-size: 12px; color: black;">Solution By: Surplusdev.com</p>
                                        </td>
                                    </tr>
                                </tbody></table>

                            </td>
                        </tr>
                        
                        <!--1 Column-->
                        

                        <!--Footer-->
                        
                        
                    </tbody></table>
                    
                    <!--[if (gte mso 9)|(IE)]>
                          </td>
                        </tr>
                      </table>
                    <![endif]-->
                </td>
            </tr>
        </tbody>

        </table>
    

</body></html>
               
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