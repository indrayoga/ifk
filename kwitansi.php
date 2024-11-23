<?php 
    session_start();
$server = "localhost";
$username = "root";
$password = "Bpp1bnu51n41251.";
$database = "db_ibnusina";
 date_default_timezone_set("Asia/Singapore"); 

// Koneksi dan memilih database di server
mysql_connect($server,$username,$password) or die("Koneksi gagal");
mysql_select_db($database) or die("Database tidak bisa dibuka");

    include 'WebClientPrint.php';
    use Neodynamic\SDK\Web\WebClientPrint;
    use Neodynamic\SDK\Web\Utils;
    use Neodynamic\SDK\Web\DefaultPrinter;
    use Neodynamic\SDK\Web\InstalledPrinter;
    use Neodynamic\SDK\Web\PrintFile;
    use Neodynamic\SDK\Web\ClientPrintJob;

    // Process request
    // Generate ClientPrintJob? only if clientPrint param is in the query string
    $urlParts = parse_url($_SERVER['REQUEST_URI']);
    
            //IMPORTANT: 
            //- For Windows, MS Excel needs to be installed at the client side
            //- For Linux & Mac, LibreOffice needs to be installed at the client side
            $useDefaultPrinter = ($qs['useDefaultPrinter'] === 'checked');
            $printerName = urldecode($qs['printerName']);

            //the xls file to be printed, supposed to be in files folder
            $filePath = 'download/kwitansi.xls';
            //create a temp file name for our XLS file...
            $fileName = uniqid().'.xls';
            
            //Create a ClientPrintJob obj that will be processed at the client side by the WCPP
            $cpj = new ClientPrintJob();
            //Create a PrintFile object with the XLS file
            $cpj->printFile = new PrintFile($filePath, $fileName, null);
                $cpj->clientPrinter = new DefaultPrinter();

            //Send ClientPrintJob back to the client
            ob_clean();
            echo $cpj->sendToClient();
            exit();
?>

