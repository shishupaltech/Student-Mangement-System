<?php
include 'connection.php';
include '../TCPDF/tcpdf.php';


class PdfFileDownload{
    private $conn;
    
    public function __construct(){
        $this->conn = new ConnPDO();
        
    }
    public function action(){
        // if(isset($_REQUEST['action']) && $_REQUEST['action']=='generateReport'){
        //     $this->downloadPdfFile();
        // }
        $this->downloadPdfFile();
    }

    // creating function for the dynamic cell according to data.
   function makeMyList($getValueFromArray,$array,$pdf){
      while($getValueFromArray<count($array)-1){
        $w = 95/(count($array)-2);
        $pdf->SetFont('helvetica', 'B', 13);
        $pdf->Cell($w, 10, $array[$getValueFromArray], 1, 0, 'C', 0, '', 0);
        $getValueFromArray++;
    }
    $pdf->Ln();
   }
    function downloadPdfFile(){
        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true,'UTF-8',false);

        $host = "localhost";
        $dbname = "recordsofstudents";
        $username = "root";
        $password = "";

        // Connect to the database
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $query = "select * from result";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $data = $stmt->fetchAll();

        // Set font and add table
        $pdf->SetFont('helvetica', '', 8);
        $pdf->AddPage();
        $border_color = array(0, 0, 0);
        $pdf->Rect(5, 5, 200, 287, 'D', '', $border_color);
        //Table Headers
        $count = 0;
        $val = 1;
        // print_r($arrayPrice);
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'My PDF Header');
        $pdf->SetFont('Helvetica', '', 32);
        $pdf->Cell(190,20,"Winnner Price", 1, 0, 'C', 0, '', 0);
        $pdf->Ln();
        //for first row with firstprice.
        $startingIndex=0;
        $getValueFromArray=1;
        $pdf->SetFont('helvetica', 'B', 17);
        $val=$data[$startingIndex]['result_no'];
        $array = explode(":", $val);
        $pdf->Cell(95, 10, "1st Prize  Rs.10000/-", 1, 0, 'L', 0, '', 0);
        $this->makeMyList($getValueFromArray,$array,$pdf);
        $startingIndex++;
        // for second row with secondprice.
        $pdf->SetFont('helvetica', 'B', 15);
        $val=$data[$startingIndex]['result_no'];
        $array = explode(":", $val);
        $pdf->Cell(95, 10, "2nd Prize  Rs.1000/-", 1, 0, 'L', 0, '', 0);
        $this->makeMyList($getValueFromArray,$array,$pdf);
        $startingIndex++;
        // for 3rd row with third price.
        $pdf->SetFont('helvetica', 'B', 13);
        $val=$data[$startingIndex]['result_no'];
        $array = explode(":", $val);
        $pdf->Cell(95, 10, "3rd Prize  Rs.500/-", 1, 0, 'L', 0, '', 0);
        $this->makeMyList($getValueFromArray,$array,$pdf);
        // for 4th row with 4th price.
        $startingIndex++;
        $pdf->SetFont('helvetica', 'B', 12);
        $val=$data[$startingIndex]['result_no'];
        $array = explode(":", $val);
        $pdf->Cell(95, 10, "4th Prize  Rs.200/-", 1, 0, 'L', 0, '', 0);
        $this->makeMyList($getValueFromArray,$array,$pdf);
        // for the fifth row with all the winner in game.
        $pdf->SetFont('helvetica', 'B', 18);
        $pdf->Cell(190, 10, "5th Prize  Rs.100/-", 1, 0, 'C', 0, '', 0);
        $pdf->Ln();
            
        foreach($data as $row) {
           
            if ($count < 4) {
            }else{
              $pdf->SetFont('helvetica', 'B', 13);
                $result = explode(":",$row['result_no']);
                $i = 1;
                foreach($result as $data){
                  if(empty($data)){
                        continue;
                  }
                  
                  if ($i <= 15) {
                    $pdf->Cell(12.7, 10, $data, 1, 0, 'C', 0, '', 0);
                  }
                  if ($i == 15) {
                    $pdf->Ln();
                    $i = 0;
                  }
                  $i++;
                }
                $pdf->Ln();
            }
        $count++;
        }
        // $html = '<h1>My PDF</h1><p>This is an example PDF generated using TCPDF with an image:</p>';

// Add the image
$html = '<br>';
$pdf->writeHTML($html,True,False,True,False,'');
$image_file = '../images/sugaldamani.png';
$image_width=195;
$image_height=40;
$pdf->Image($image_file, $x = '', $y = '', $image_width, $image_height);
// echo $image;

// Output the HTML
// $pdf->writeHTML($html, true, false, true, false, '');


        ob_end_clean();
        // Output the PDF document
        $pdf->Output('Student Data.pdf', 'D');

    }
}

$pdf = new PdfFileDownload();
$pdf->action();

?>