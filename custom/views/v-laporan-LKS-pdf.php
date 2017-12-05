<?php



// extend TCPF with custom functions
class MYPDF extends TCPDF {

	// Load table data from file
	public function LoadData($file) {
		// Read file lines
		$lines = file($file);
		$data = array();
		foreach($lines as $line) {
			$data[] = explode(';', chop($line));
		}
		return $data;
	}

	public function DrawHeader($header, $w) {
        // Colors, line width and bold font
        // Header
		$this->SetFillColor(255, 0, 0);
		$this->SetTextColor(255);
		$this->SetDrawColor(128, 0, 0);
		$this->SetLineWidth(0.3);
		$this->SetFont('', 'B');        
		$num_headers = count($header);
		for($i = 0; $i < $num_headers; ++$i) {
			$this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
		}
		$this->Ln();
        // Color and font restoration
		$this->SetFillColor(224, 235, 255);
		$this->SetTextColor(0);
		$this->SetFont('');
    }

	// Colored table
	public function ColoredTable($header,$data) {
		$w = array(10, 30, 50, 15, 15,15,15,15,15);
		   $this->DrawHeader($header, $w);
		$fill = 0;
		foreach($data as $row) {
			//Get current number of pages.
			$num_pages = $this->getNumPages();

      $this->startTransaction();
			$this->Cell($w[0], 9, $row['no'], 'LR', 0, 'L', $fill);
			$this->Cell($w[1], 9, ($row['namaDepan']." ".$row['namaBelakang']), 'LR', 0, 'LR', $fill);
			$this->Cell($w[2], 9, ($row['nm_paket']), 'LR', 0, 'C', $fill);
			$this->Cell($w[3], 9, ($row['jumlah_soal']), 'LR', 0, 'C', $fill);
			$this->Cell($w[4], 9, ($row['jmlh_salah']), 'LR', 0, 'C', $fill);
			$this->Cell($w[5], 9, ($row['jmlh_benar']), 'LR', 0, 'C', $fill);
			$this->Cell($w[6], 9, ($row['nilai_praktek']), 'LR', 0, 'C', $fill);
			$this->Cell($w[7], 9, ($row['nilai']), 'LR', 0, 'C', $fill);
			$this->Cell($w[8], 9, ($row['nilai_akhir']), 'LR', 0, 'C', $fill);
			$this->Ln();
			 //If old number of pages is less than the new number of pages,
            //we hit an automatic page break, and need to rollback.
			//repeat header
			if($num_pages < $this->getNumPages())
			{
        //Undo adding the row.
				$this->rollbackTransaction(true);
      	//Adds a bottom line onto the current page. 
      	//Note: May cause page break itself.
				// $this->Cell(array_sum($w), 0, '', 'T');
      	//Add a new page.
				$this->AddPage();
      	//Draw the header.
				$this->DrawHeader($header, $w);
      	//Re-do the row.
				$this->Cell($w[0], 9, $row['no'], 'LR', 0, 'L', $fill);
			$this->Cell($w[1], 9, ($row['namaDepan']), 'LR', 0, 'LR', $fill);
			$this->Cell($w[2], 9, ($row['nm_paket']), 'LR', 0, 'C', $fill);
			$this->Cell($w[3], 9, ($row['jumlah_soal']), 'LR', 0, 'C', $fill);
			$this->Cell($w[4], 9, ($row['jmlh_salah']), 'LR', 0, 'C', $fill);
			$this->Cell($w[5], 9, ($row['jmlh_benar']), 'LR', 0, 'C', $fill);
			$this->Cell($w[6], 9, ($row['nilai_praktek']), 'LR', 0, 'C', $fill);
			$this->Cell($w[7], 9, ($row['nilai']), 'LR', 0, 'C', $fill);
			$this->Cell($w[8], 9, ($row['nilai_akhir']), 'LR', 0, 'C', $fill);
				$this->Ln();
			}
			else
			{
                //Otherwise we are fine with this row, discard undo history.
				$this->commitTransaction();
			}
			//
			$fill=!$fill;
		}
		$this->Cell(array_sum($w), 0, '', 'T');
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('GENERASI CERDAS');
$pdf->SetTitle('Laporan_LKS');
$pdf->SetSubject('Laporan_LKS_PDF');
$pdf->SetKeywords('TCPDF, PDF, a, LKS, Laporan');

// set default header data
$img=base_url().'/assets/back/img/logo_cerdas.png';
$pdf->SetHeaderData('logo_cerdas.png', '10%', "Laporan Hasil LKS",PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 9);

// add a page
$pdf->AddPage();

// column titles
$header = array('No','Nama ', 'Nama Paket','Jumlah'."\n".'Soal','Salah','Benar','Prakterk','Nilai CBT', 'Nila Akhir');

// data loading
//judul tabel
$nameTbl='<h1>Laporan Nilai Akhir Peserta LKS</h1><br>
		<p>Dibawah ini adalah daftar nilai akhir untuk test CBT untuk paket.<p/>';

$pdf->writeHTML($nameTbl,false, false, false, false, '');
// print colored table
$pdf->ColoredTable($header, $all_report);

// ---------------------------------------------------------
$kesimpulan='<br><h1>Kesimpulan</h1>
';
$pengeantar_kesimpulan="dibawah ini hasil rekap adari test hasil CBT dan Test Praktek yaitu : <br> <br>";
$pdf->writeHTML($kesimpulan,false, false, false, false, '');
$pdf->writeHTML($pengeantar_kesimpulan,false, false, false, false, '');

$tbl = '
<table border="0" style="width:50%;">
	 <tr>
	    <th align="left" style="background-color:#FAF6F6;"><b>- Jumlah Siswa</b></th>
	    <td width="5%" style="background-color:#FAF6F6;">:</td>
	    <td align="left" style="background-color:#FAF6F6;">'.$jmlh_peserta.'</td>
	 </tr>
	  <tr >
	    <th align="left"style="background-color:#E3F2F9;"><b>- Rata-rata</b></th>
	   <td width="5%" style="background-color: #E3F2F9;">:</td>
	    <td align="left" style="background-color: #E3F2F9;">'.$avg.'</td>
	 </tr>
	  <tr >
	    <th align="left" style="background-color:#FAF6F6;"><b>- Nilai Terbesar</b></th>
	    <td width="5%" style="background-color:#FAF6F6;">:</td>
	    <td align="left" style="background-color:#FAF6F6;">'.$maxNilai.'</td>
	 </tr>

 </table> '
 ;
$pdf->writeHTML($tbl,  true, false, true, false, '');
// close and output PDF document
$pdf->Output('Laporan_LKS.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+