<?php

namespace App\Http\Controllers;

use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Blowing;
use App\Models\Blowdata;
use App\Models\Client;


class PdfController extends Controller
{
    private $max_speed = 0;
    private $max_force = 0;
    private $max_velocity = 0;
    private $max_pressure = 0;
    private $max_length = 0;

    private $max_length_scale_value = 0;
    private $max_velocity_scale_value = 0;
    private $max_pressure_scale_value = 0;
    private $max_force_scale_value = 0;

    private $aBlowdata = Array();


    private function draw_pressure_Y_axis() {

        $style_blue = array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 255));
        PDF::SetTextColor(0,0,0);
        PDF::SetFont ('opensans', '', 9, '', 'default', true );
        PDF::StartTransform();
        PDF::Rotate(90,105,105);
        PDF::SetTextColor(0,0,255);
        PDF::Text(0, 201, 'Pressure [ bar ]');
        PDF::StopTransform();
        $line_start = 140;
        $line_lengh = 120;
        PDF::SetFont ('opensans', '', 7, '', 'default', true );

        PDF::Line(196, $line_start, 196, $line_start+$line_lengh, $style_blue); // linia Y (Pressuee)

        $scale_pressure = $line_lengh/$this->max_pressure_scale_value;

        $i = $line_start;
        $step = round($this->max_pressure_scale_value/15); // chcemy miec 15 podziałek na skali

        for ($i=0; $i<= $this->max_pressure_scale_value; $i=$i+$step ) {
            PDF::Text(196+1, $line_start+($i*$scale_pressure)-2, $this->max_pressure_scale_value-$i);
            PDF::Line(196, $line_start+($i*$scale_pressure), 196+1, $line_start+($i*$scale_pressure), $style_blue); // linia Y (Pressuee)
        }
    }

    private function draw_pressure_Y_data() {

        $style_blue = array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 255));
        $how_many_records = count($this->aBlowdata); // 193
        
        $start_x = 15;
        $start_y = 260;
        $end_x = 185;
        $end_y = 140;

        $scale_x = ($end_x - $start_x) / $how_many_records;
        $scale_y = ($end_y - $start_y) / $this->max_pressure_scale_value;

        for ($i=1; $i< count($this->aBlowdata); $i++) {
            $x1 = (($i-1)*$scale_x)+$start_x;
            $y1 = ($this->aBlowdata[$i-1]->pressure*$scale_y)+$start_y;
            $x2 = ($i*$scale_x)+$start_x;
            $y2 = ($this->aBlowdata[$i]->pressure*$scale_y)+$start_y;
            PDF::Line($x1, $y1, $x2, $y2, $style_blue);
        }
    }



    private function draw_velocity_Y_axis() {
        $style_red = array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 0, 0));
        PDF::SetFont('opensans', '', 9);
        PDF::StartTransform();
        PDF::Rotate(90,106,106);
        PDF::SetTextColor(255,0,0);
        PDF::Text(0, 191, 'Velocity [ m/min ]');
        PDF::StopTransform();
        $line_start = 140;
        $line_lengh = 120;
        PDF::SetFont ('opensans', '', 7, '', 'default', true );
        PDF::Line(185, $line_start, 185, $line_start+$line_lengh, $style_red); // linia Y (Pressuee)

        $scale_velociy = $line_lengh/$this->max_velocity_scale_value;
        $step = $this->calculate_step($this->max_velocity_scale_value/10);

        for ($i=0; $i<= $this->max_velocity_scale_value; $i=$i+$step) {
             PDF::Text(185+1, $line_start+($i*$scale_velociy)-2, round($this->max_velocity_scale_value-$i));
             PDF::Line(185, $line_start+($i*$scale_velociy), 185+1, $line_start+($i*$scale_velociy), $style_red);
        }
    }


    private function draw_velocity_Y_data() {
    
        $style_red = array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(200, 0, 0));
        //$this->max_length_scale_value
        $how_many_records = count($this->aBlowdata); // 193
        
        $start_x = 15;
        $start_y = 260;
        $end_x = 185;
        $end_y = 140;

        $scale_x = ($end_x - $start_x) / $how_many_records;
        $scale_y = ($end_y - $start_y) / $this->max_velocity_scale_value;

        for ($i=1; $i< count($this->aBlowdata); $i++) {
            $x1 = (($i-1)*$scale_x)+$start_x;
            $y1 = ($this->aBlowdata[$i-1]->speed*$scale_y)+$start_y; // w bazie jest speed zamiast velocity

            $x2 = ($i*$scale_x)+$start_x;
            $y2 = ($this->aBlowdata[$i]->speed*$scale_y)+$start_y; // w bazie jest speed zamiast velocity

            PDF::Line($x1, $y1, $x2, $y2, $style_red);
        }

    }




    private function draw_force_Y_axis() {
        $style_green = array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 180, 0));
        $style_grey = array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 1, 'color' => array(111, 111, 111));

        PDF::SetTextColor(0,180,0);
        PDF::SetFont ('opensans', '', 9, '', 'default', true );
        PDF::StartTransform();
        PDF::Rotate(90,105,105);
        PDF::Text(0, 4, 'Force [ F ]');

        PDF::StopTransform();
        $line_start = 140;
        $line_lengh = 120;
        PDF::SetFont ('opensans', '', 7, '', 'default', true );
        PDF::Line(15, $line_start, 15, $line_start+$line_lengh, $style_green); // linia Y (Pressuee)

        $scale_velociy = $line_lengh/$this->max_force_scale_value;
        $step = $this->calculate_step($this->max_force_scale_value/10);

        for ($i=0; $i<= $this->max_force_scale_value; $i=$i+$step) {
             PDF::Line(15, $line_start+($i*$scale_velociy), 15-1,   $line_start+($i*$scale_velociy), $style_green);
             PDF::Line(15, $line_start+($i*$scale_velociy), 170+15, $line_start+($i*$scale_velociy), $style_grey);
             PDF::Text(15-7,$line_start+($i*$scale_velociy)-2, floor($this->max_force_scale_value-$i));
        }
        PDF::StopTransform();
    }



    private function draw_force_Y_data() {

        $style_green = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 180, 0));        
        
        $how_many_records = count($this->aBlowdata); // 193
        
        $start_x = 15;
        $start_y = 260;
        $end_x = 185;
        $end_y = 140;

        $scale_x = ($end_x - $start_x) / $how_many_records;
        $scale_y = ($end_y - $start_y) / $this->max_force_scale_value;


        for ($i=1; $i< count($this->aBlowdata); $i++) {
            $x1 = (($i-1)*$scale_x)+$start_x;
            $y1 = ($this->aBlowdata[$i-1]->force*$scale_y)+$start_y;
            $x2 = ($i*$scale_x)+$start_x;
            $y2 = ($this->aBlowdata[$i]->force*$scale_y)+$start_y;
            
            PDF::Line($x1, $y1, $x2, $y2, $style_green);
        }

    }


    private function calculate_step($raw_step) {
        $compare = Array();
        $multiplier = 0.00001;
        while ($multiplier < 1000000) {
            $compare[]  = $multiplier * 1;
            $compare[]  = $multiplier * 2;
            $compare[]  = $multiplier * 5;
            $multiplier = $multiplier * 10;
        }

        for ($i=1; $i<count($compare); $i++) {
            $a = $compare[$i-1];
            $b = $compare[$i];
            if (($raw_step > $a) && ($raw_step < $b)) {
                $delta1 = $raw_step - $a;
                $delta2 = $b - $raw_step;
                return ($delta2 < $delta1) ? $compare[$i] : $compare[$i-1];
                // if ($delta2 < $delta1) {
                //     return $compare[$i];
                // } else {
                //     return $compare[$i-1];
                // }
            }
        }
        print "Problem z obliczeniem step! Plik:".__FILE__. "linia: ".__LINE__;
        exit;
    }

    private function draw_length_X_axis() {
        $style_black = array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
        $style_grey = array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 1, 'color' => array(111, 111, 111));
        PDF::SetTextColor(0,0,0);
        PDF::SetFont ('opensans', '', 9, '', 'default', true );
        $line_start = 15;
        $line_length = 170;
        PDF::Text(85, 266, 'Length [m]');
        PDF::SetFont ('opensans', '', 7, '', 'default', true );
        PDF::Line($line_start, 260, $line_start+$line_length, 260, $style_black); // linia X (length)

        $scale_length = $line_length/$this->max_length_scale_value;
        $step = $this->calculate_step($this->max_length_scale_value/10);

        for ($i=0; $i<= $this->max_length_scale_value; $i=$i+$step) {
             PDF::Text($line_start+($i*$scale_length)-2, 262 , $i);
             PDF::Line($line_start+($i*$scale_length), 260, $line_start+($i*$scale_length), 261, $style_black);
             PDF::Line($line_start+($i*$scale_length), 140, $line_start+($i*$scale_length), 261, $style_grey);
        }
    }


    public function showChart($blowing_id) {

        // sprawdzenie czy blowing należy do usera który jest akurat zalogowany
        $logged_user_id = auth()->user()->id;
        $blowing = DB::table('blowings')
                    ->join('users', 'blowings.user_id', '=', 'users.id')
                    ->select('blowings.*')
                    ->where('users.id', $logged_user_id)
                    ->where('blowings.id', '=', $blowing_id)
                    ->get();

        if ($blowing->count() == 0) {
            return redirect('/blowings/list');
        }

        $this->aBlowdata = DB::table('blowdatas')
                    ->select('blowdatas.*')
                    ->where('blowing_id', '=', $blowing_id)
                    ->get();

        if ($this->aBlowdata->count() == 0) {
            if ($blowing->numbers_of_samples_from_file > 0) {

                Blowing::where("user_id", $logged_user_id)
                    ->where("id", $blowing_id)
                    ->update(["numbers_of_samples_from_file"=>0]);
            }

            return redirect()->route('blowings.blowingsList')->withError('No source data available for blowing ('.$blowing[0]->date_time_from_file).")";
            exit;
        }



        // specjalnie robie to w PHP a nie biore MAX z bazy bo baza będzie miała dużo rekordów i może zamulać.
        // a tych rekordów będzie z jednego wdmuchiwania mniej niż 100
        foreach ($this->aBlowdata as $item) {
            if ($item->speed    > $this->max_velocity)  { $this->max_velocity = $item->speed; }
            if ($item->force    > $this->max_force)     { $this->max_force    = $item->force; }
            if ($item->pressure > $this->max_pressure)  { $this->max_pressure = $item->pressure; }
            if ($item->length   > $this->max_length)    { $this->max_length   = $item->length; }
        }


// $pdf = new \TCPDF();
// $pdf->SetFont('freeserif', '', 12);
// $pdf->AddPage();
// $utf8text = "łżźćółćóżźćłźłćłąśł";
// $pdf->Write(5, $utf8text, '', 0, '', false, 0, false, false, 0);
// $pdf->Output('example_008.pdf', 'I');
// exit;



// Custom Header
PDF::setHeaderCallback(function($pdf) {
        // Set font
    $pdf->SetFont('helvetica', 'B', 20);
    #var_dump($pdf->getAliasNumPage()) ;
    
// nazwa klienta        Blow-in protocol        Terma MultiTyphoon R
// Route / Project no. Trasa Principal terma
// Location (GPS) 0.0000 0.0000 Section Odcinek początek Odcinek koniec
// City / Place Miejscowość Date 2021-12-07 Section length 95 m
// Cable diameter 13.0 Start time 15:05:03 End time 15:58:43


#        $pdf->SetY(15);
 #       $pdf->SetX(15);
 #       $pdf->Cell(10, 10, 'Strona druga i kolejne '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages(), 0, false, 'L', 0, '', 0, false, 'T', 'M');

        //$pdf->Cell(0, 1, 'Something new right here!!!', 0, false, 'C', 0, '', 0, false, 'M', 'M');

PDF::SetFont ('opensans', '', 9, '', 'default', true );
$pdf->SetY(10);
PDF::setCellPaddings( 1,1.5,1,1);

PDF::SetFont("freesans", "B", 10);
PDF::MultiCell(63.33, 10, 'Nazwa klienta', 1, 'C', 0, 0, '', '', true);
PDF::SetFont("freesans", "B", 14);
PDF::MultiCell(63.33, 10, 'Blow In protocol', 1, 'C', 0, 0, '' ,'', true);
PDF::SetFont("freesans", "B", 10);
PDF::MultiCell(63.33, 10, 'Logo terma', 1, 'C',  0, 1, '', '', true);
PDF::Ln(0);

PDF::SetFont("freesans", "B", 6);
PDF::MultiCell(31.66, 6, "Route / Project no.", 'LBT', 'C', 0, 0, '', '', true);
PDF::SetFont("freesans", "", 6);
PDF::MultiCell(31.66, 6, "Trasa", 'RBT', 'C', 0, 0, '', '', true);
PDF::SetFont("freesans", "B", 6);
PDF::MultiCell(31.66, 6, "Section", 'LBT', 'C', 0, 0, '', '', true); // Client
PDF::SetFont("freesans", "", 6);
PDF::MultiCell(95,    6, "Księgarnia -> Stalowe młyny (95m)", 'RBT', 'C', 0, 0, '', '', true); // terms

PDF::Ln(6);
PDF::SetFont("freesans", "B", 6);
PDF::MultiCell(31.66, 6, "City", 'LBT', 'C', 0, 0, '', '', true);
PDF::SetFont("freesans", "", 6);
PDF::MultiCell(31.66, 6, "Gdańsk", 'RBT', 'C', 0, 0, '', '', true);
PDF::SetFont("freesans", "B", 6);
PDF::MultiCell(31.66, 6, "Date Time", 'LBT', 'C', 0, 0, '', '', true);
PDF::SetFont("freesans", "", 6);
PDF::MultiCell(95,    6, "2022-06-30 21:00 -> 23:30", 'RBT', 'C', 0, 0, '', '', true);


// PDF::MultiCell(95, 10, "Termafiber", 1, 'C', 0, 0, '', '', true);
// PDF::MultiCell(95, 10, "Telekomunikacja Polska", 1, 'C', 0, 0, '' ,'', true);
// PDF::Ln(0);
// $pdf->setCellPaddings( $left = '', $top = '', $right = '', $bottom = '');


});

// Custom Footer
PDF::setFooterCallback(function($pdf) {
        // Position at 15 mm from bottom
        $pdf->SetY(-15);
        $pdf->SetX(15);
        // Set font
        $pdf->SetFont('helvetica', 'I', 8);
        // Page number
        $pdf->Cell(10, 10, 'Page '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
});


/*
PDF::setPrintHeader(true);
PDF::setPrintFooter(true);
// PDF::setPrintHeader(false);
// PDF::setPrintFooter(false);
    
PDF::SetAuthor('System');
PDF::SetTitle('My Report');
PDF::SetSubject('Report of System');
//PDF::SetMargins(7, 18, 7);
PDF::SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
PDF::SetFontSubsetting(false);
PDF::SetFontSize('10px');   
PDF::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);     
//PDF::AddPage('L', 'A4');
PDF::AddPage();
$html = 'Write something here';
PDF::writeHTML($html, true, false, true, false, '');
#PDF::lastPage();

PDF::AddPage();
//PDF::setHeaderTemplateAutoreset(false);
PDF::writeHTML($html, true, false, true, false, '');

// PDF::Output('my_file.pdf', 'D');
PDF::Output('example_012.pdf', 'I');
exit;
*/

// #MultiCell(w, h, txt, border = 0, align = 'J', fill = 0, ln = 1, x = '', y = '', reseth = true, stretch = 0, ishtml = false, autopadding = true, maxh = 0) ⇒ Object
// Also known as: multi_cell

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

/*



PDF::SetFont("freesans", "B", 20);
PDF::Cell(0,10,"Internal text",1,1,'C');
PDF::SetFont("freesans", "B", 15);
PDF::Cell(0,10,"Internal text",1,1,'C');
PDF::SetFont("freesans", "B", 10);
PDF::Cell(95,10,"Internal text",1,1,'C');
PDF::Cell(95,10,"Internal text Internal text",1,1,'C');
//Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=0, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')

PDF::AddPage();
PDF::SetFont("freesans", "B", 20);
PDF::Cell(0,10,"Internal text",1,1,'C');
PDF::SetFont("freesans", "B", 15);
PDF::Cell(0,10,"Internal text",1,1,'C');
PDF::SetFont("freesans", "B", 10);
PDF::Cell(95,10,"Internal text",1,1,'C');
PDF::Cell(95,10,"Internal text Internal text",1,1,'C');


$txt = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.';
 PDF::SetFillColor(249,249,249);

PDF::MultiCell(55, 5, '[LEFT] '. $txt, 1, 'L', 1, 0, '', '', true);
$Xorigin = PDF::GetX();
$Yorigin = PDF::GetY();

PDF::MultiCell(55, 5, '[RIGHT] '  .$txt, 1, 'R', 0, 1, '', '', true);
PDF::MultiCell(55, 5, '[CENTER] ' .$txt, 1, 'C', 0, 0, '', '', true);
PDF::MultiCell(55, 5, '[JUSTIFY] '.$txt, 1, 'J', 1, 2, '' ,'', true);
PDF::MultiCell(55, 5, '[DEFAULT] '.$txt, 1, '',  0, 1, '', '', true);
PDF::Ln(4);
PDF::SetFillColor(220, 255, 220);
PDF::MultiCell(55, 40, '[VERTICAL ALIGNMENT - TOP] '.$txt, 1, 'J', 1, 0, '', '', true, 0, false, true, 40, 'T');
PDF::MultiCell(55, 40, '[VERTICAL ALIGNMENT - MIDDLE] '.$txt, 1, 'J', 1, 0, '', '', true, 0, false, true, 40, 'M');
PDF::MultiCell(55, 40, '[VERTICAL ALIGNMENT - BOTTOM] '.$txt, 1, 'J', 1, 1, '', '', true, 0, false, true, 40, 'B');
PDF::Ln(4);

// PDF::Output("HappyCover.pdf", "I");
// exit;
*/
// --------------------------------------------------------------------------------------------------------------




    PDF::SetCreator('http://termafiber.pl/');
    PDF::SetAuthor('http://termafiber.pl/');
    PDF::SetTitle('Fiber report');
    PDF::SetSubject('Fiber report');
    PDF::SetKeywords('Fiber report');

    // disable header and footer
    PDF::setPrintHeader(false);
    PDF::setPrintFooter(false);
    PDF::SetFont ('opensans', '', 9, '', 'default', true );

    // set default monospaced font
    // PDF::SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); // to chyba nie potrzebne

    // set margins
    //PDF::SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

    // set auto page breaks
    #PDF::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    #PDF::setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        PDF::setLanguageArray($l);
    }

PDF::AddPage();

 
    // adaptacyjne wyliczanie jednostek dla osi X dla długości wdmuchniętego światłowodu
    $this->max_length_scale_value = $this->max_length; // tutaj nie chcę żadnego sztucznego wydłużania osi tak jak to było dla prędkości i siły
    $this->draw_length_X_axis();

    // tutaj się przepełnia pamięć PHPa dla małych ilości odczytów w pliku "Parameters.txt" !!S

    // adaptacyjne wyliczanie jednostek dla osi Y dla wartości VELOCITY
    $this->max_velocity_scale_value = $this->max_velocity + 10 - ($this->max_velocity % 10); // sztuczne wydłużenie osi o wielokrotność dziesięciu
    $this->draw_velocity_Y_axis();
    $this->draw_velocity_Y_data();

    // PRESSURE nie musi mieć ani adaptacyjnej osi Y ani wydłużanej bo ciśnienie nigdy nie będzie wyższe niż 26
    $this->max_pressure_scale_value = 26;
    $this->draw_pressure_Y_axis();
    $this->draw_pressure_Y_data();

    // adaptacyjne wyliczanie jednostek dla osi Y dla wartości FORCE
    $this->max_force_scale_value = floor($this->max_force + 5 - ($this->max_force % 5)); // sztuczne wydłużenie osi o wielokrotność pięciu
    $this->draw_force_Y_axis();
    $this->draw_force_Y_data();



// #MultiCell(w, h, txt, border = 0, align = 'J', fill = 0, ln = 1, x = '', y = '', reseth = true, stretch = 0, ishtml = false, autopadding = true, maxh = 0) ⇒ Object

PDF::SetLineStyle(array('width' => 0.2, 'color' => array(0, 0, 0)));
#$pdf->SetFillColor(255,255,128);
PDF::SetTextColor(0,0,0);
PDF::SetY(10); /// ???
PDF::SetX(10);

PDF::setPrintHeader(false);
PDF::setPrintFooter(false);
PDF::SetFont("freesans", "B", 10);
PDF::setCellPaddings( 0,2,0,0);
PDF::MultiCell(63.33, 10, 'Nazwa klienta', 1, 'C', 0, 0, '', '', true);
PDF::SetFont("freesans", "B", 14);
PDF::setCellPaddings( 0,1.5,0,0);
PDF::MultiCell(63.33, 10, 'Blow In protocol', 1, 'C', 0, 0, '' ,'', true);
PDF::SetFont("freesans", "B", 10);
PDF::setCellPaddings( 0,2,0,0);
PDF::MultiCell(63.33, 10, 'Logo terma', 1, 'C',  0, 1, '', '', true);
PDF::setCellPaddings( 1,1.5,1,1);
PDF::MultiCell(95, 16, "Termafiber\nul Czaple 100\n80-180 Gdańsk", 1, 'C', 0, 0, '', '', true);
PDF::MultiCell(95, 16, "Telekomunikacja Polska\nDługa 18\n80-180 Gdańsk", 1, 'C', 0, 0, '' ,'', true);
PDF::Ln(0);
// $pdf->setCellPaddings( $left = '', $top = '', $right = '', $bottom = '');



PDF::SetFont("freesans", "B", 6);
PDF::SetY(14);
PDF::Cell(95,16,"Contractor",0,1,'L');
PDF::SetY(14);
PDF::SetX(105);
PDF::Cell(95,16,"Client",0,1,'L');

//PDF::SetY(35.6);
PDF::SetX(10);
PDF::SetY(36);

PDF::SetFont("freesans", "B", 6);
PDF::SetFillColor(229,229,229); // Grey
PDF::MultiCell(31.66, 6, "Route / Project no.", 'LBT', 'C', 1, 0, '', '', true);
PDF::MultiCell(31.66, 6, "Trasa", 'RBT', 'C', 0, 0, '', '', true);
PDF::MultiCell(31.66, 6, "Section", 'LBT', 'C', 1, 0, '', '', true);
PDF::SetFont("freesans", "", 6);
PDF::MultiCell(95,  6, "Odcinek początek  →  Odcinek koniec", 'RBT', 'C', 0, 0, '', '', true);


PDF::Ln(6);
PDF::SetFont("freesans", "B", 6);
PDF::MultiCell(31.66, 6, "Location (GPS)", 'LBT', 'C', 1, 0, '', '', true);
PDF::SetFont("freesans", "", 6);
PDF::MultiCell(31.66, 6, "0.0000 0.0000", 'RBT', 'C', 0, 0, '', '', true);
PDF::SetFont("freesans", "B", 6);
PDF::MultiCell(31.66, 6, "Link", 'LBT', 'C', 1, 0, '', '', true);
PDF::SetFont("freesans", "", 6);
PDF::MultiCell(95,    6, "https://www.google.com/maps/place/0.0000,0.0000", 'RBT', 'C', 0, 0, '', '', true);

PDF::Ln(6);
PDF::SetFont("freesans", "B", 6);
PDF::MultiCell(31.66, 6, "City / Place", 'LBT', 'C', 1, 0, '', '', true);
PDF::SetFont("freesans", "", 6);
PDF::MultiCell(31.66, 6, "Miejscowość", 'RBT', 'C', 0, 0, '', '', true);
PDF::SetFont("freesans", "B", 6);
PDF::MultiCell(31.66, 6, "Date", 'LBT', 'C', 1, 0, '', '', true);
PDF::SetFont("freesans", "", 6);
PDF::MultiCell(31.66, 6, "2021-12-07", 'RBT', 'C', 0, 0, '', '', true);
PDF::SetFont("freesans", "B", 6);
PDF::MultiCell(31.66, 6, "Length [m]", 'LBT', 'C', 1, 0, '', '', true);
PDF::SetFont("freesans", "", 6);
PDF::MultiCell(31.66, 6, "95", 'RBT', 'C', 0, 0, '', '', true);


PDF::Ln(6);
PDF::SetFont("freesans", "B", 6);
PDF::MultiCell(31.66, 6, "Ambient temperature [°C]", 'LBT', 'C', 1, 0, '', '', true);
PDF::SetFont("freesans", "", 6);
PDF::MultiCell(31.66, 6, "0.00", 'RBT', 'C', 0, 0, '', '', true);
PDF::SetFont("freesans", "B", 6);
PDF::MultiCell(31.66, 6, "Installation time", 'LBT', 'C', 1, 0, '', '', true);
PDF::SetFont("freesans", "", 6);
PDF::MultiCell(31.66, 6, "0:53:40", 'RBT', 'C', 0, 0, '', '', true);
PDF::SetFont("freesans", "B", 6);
PDF::MultiCell(31.66, 6, "Marker: start / end", 'LBT', 'C', 1, 0, '', '', true);
PDF::SetFont("freesans", "", 6);
PDF::MultiCell(31.66, 6, "Marker", 'RBT', 'C', 0, 0, '', '', true);


PDF::Ln(6);

PDF::SetFont("freesans", "B", 6);
PDF::MultiCell(31.66, 6, "Operator", 'LBT', 'C', 1, 0, '', '', true);
PDF::SetFont("freesans", "", 6);
PDF::MultiCell(31.66, 6, "Operator_string", 'RBT', 'C', 0, 0, '', '', true);
PDF::SetFont("freesans", "B", 6);
PDF::MultiCell(31.66, 6, "Start time", 'LBT', 'C', 1, 0, '', '', true);
PDF::SetFont("freesans", "", 6);
PDF::MultiCell(31.66, 6, "15:05:03", 'RBT', 'C', 0, 0, '', '', true);
PDF::SetFont("freesans", "B", 6);
PDF::MultiCell(31.66, 6, "End time", 'LBT', 'C', 1, 0, '', '', true);
PDF::SetFont("freesans", "", 6);
PDF::MultiCell(31.66, 6, "15:58:43", 'RBT', 'C', 0, 0, '', '', true);

PDF::Ln(6);
PDF::SetFont("freesans", "B", 6);
PDF::MultiCell(63.33, 6, "Blowing machine parameters", 1, 'C', 0, 0, '', '', true);
PDF::MultiCell(63.33, 6, "Tube parameters", 1, 'C', 0, 0, '', '', true);
PDF::MultiCell(63.33, 6, "Cable parameters", 1, 'C', 0, 0, '', '', true);


// PDF::MultiCell(31.66, 6, "Fiber blowing machine", 'LBT', 'C', 0, 0, '', '', true);
PDF::SetFont("freesans", "", 6);
//PDF::MultiCell(31.66, 6, "Terma MultiTyphoon R", 'RBT', 'C', 0, 0, '', '', true);

PDF::Ln(6);
PDF::SetFont("freesans", "B", 6);
PDF::MultiCell(31.66, 6, "Machine name", 'LBT', 'C', 1, 0, '', '', true);
PDF::SetFont("freesans", "", 6);
PDF::MultiCell(31.66, 6, "Terma MultiTyphoon R", 'RBT', 'C', 0, 0, '', '', true);
PDF::SetFont("freesans", "B", 6);
PDF::MultiCell(31.66, 6, "Manufacturer", 'LBT', 'C', 1, 0, '', '', true);
PDF::SetFont("freesans", "", 6);
PDF::MultiCell(31.66, 6, "Producent rury", 'RBT', 'C', 0, 0, '', '', true);
PDF::SetFont("freesans", "B", 6);
PDF::MultiCell(31.66, 6, "Manufacturer", 'LBT', 'C', 1, 0, '', '', true);
PDF::SetFont("freesans", "", 6);
PDF::MultiCell(31.66, 6, "Producent kable", 'RBT', 'C', 0, 0, '', '', true);



PDF::Ln(6);
PDF::SetFont("freesans", "B", 6);
PDF::MultiCell(31.66, 6, "Serial no.", 'LBT', 'C', 1, 0, '', '', true);
PDF::SetFont("freesans", "", 6);
PDF::MultiCell(31.66, 6, "MUTA0021", 'RBT', 'C', 0, 0, '', '', true);
PDF::SetFont("freesans", "B", 6);
PDF::MultiCell(31.66, 6, "Tube type", 'LBT', 'C', 1, 0, '', '', true);
PDF::SetFont("freesans", "", 6);
PDF::MultiCell(31.66, 6, "HDPE", 'RBT', 'C', 0, 0, '', '', true);
PDF::SetFont("freesans", "B", 6);
PDF::MultiCell(31.66, 6, "Mark", 'LBT', 'C', 1, 0, '', '', true);
PDF::SetFont("freesans", "", 6);
PDF::MultiCell(31.66, 6, "Oznaczenie kabla", 'RBT', 'C', 0, 0, '', '', true);


PDF::Ln(6);
PDF::SetFont("freesans", "B", 6);
PDF::MultiCell(31.66, 6, "Lubricant", 'LBT', 'C', 1, 0, '', '', true);
PDF::SetFont("freesans", "", 6);
PDF::MultiCell(31.66, 6, "Środek poślizgowy", 'RBT', 'C', 0, 0, '', '', true);
PDF::SetFont("freesans", "B", 6);
PDF::MultiCell(31.66, 6, "Mark / color", 'LBT', 'C', 1, 0, '', '', true);
PDF::SetFont("freesans", "", 6);
PDF::MultiCell(31.66, 6, "Oznaczenie rury", 'RBT', 'C', 0, 0, '', '', true);
PDF::SetFont("freesans", "B", 6);
PDF::MultiCell(31.66, 6, "Fiber ammount", 'LBT', 'C', 1, 0, '', '', true);
PDF::SetFont("freesans", "", 6);
PDF::MultiCell(31.66, 6, "Ilość włókien", 'RBT', 'C', 0, 0, '', '', true);


PDF::Ln(6);
PDF::SetFont("freesans", "B", 6);
PDF::MultiCell(31.66, 6, "Compressor", 'LBT', 'C', 1, 0, '', '', true);
PDF::SetFont("freesans", "", 6);
PDF::MultiCell(31.66, 6, "KEASSER M17A", 'RBT', 'C', 0, 0, '', '', true);
PDF::SetFont("freesans", "B", 6);
PDF::MultiCell(31.66, 6, "Outer diameter [mm]", 'LBT', 'C', 1, 0, '', '', true);
PDF::SetFont("freesans", "", 6);
PDF::MultiCell(31.66, 6, "63", 'RBT', 'C', 0, 0, '', '', true);
PDF::SetFont("freesans", "B", 6);
PDF::MultiCell(31.66, 6, "Diameter [mm]", 'LBT', 'C', 1, 0, '', '', true);
PDF::SetFont("freesans", "", 6);
PDF::MultiCell(31.66, 6, "13.0", 'RBT', 'C', 0, 0, '', '', true);



PDF::Ln(6);
PDF::SetFont("freesans", "B", 6);
PDF::MultiCell(31.66, 6, "Pressure [bar]", 'LBT', 'C', 1, 0, '', '', true);
PDF::SetFont("freesans", "", 6);
PDF::MultiCell(31.66, 6, "aqq", 'RBT', 'C', 0, 0, '', '', true);
PDF::SetFont("freesans", "B", 6);
PDF::MultiCell(31.66, 6, "Wall thickness [mm]", 'LBT', 'C', 1, 0, '', '', true);
PDF::SetFont("freesans", "", 6);
PDF::MultiCell(31.66, 6, "5.8", 'RBT', 'C', 0, 0, '', '', true);
PDF::SetFont("freesans", "B", 6);
PDF::MultiCell(31.66, 6, "Crash test [N]", 'LBT', 'C', 1, 0, '', '', true);
PDF::SetFont("freesans", "", 6);
PDF::MultiCell(31.66, 6, "Crash wynik", 'RBT', 'C', 0, 0, '', '', true);


// PDF::MultiCell(15.83, 6, "Separator", 'LBT', 'C', 1, 0, '', '', true);
// PDF::SetFont("freesans", "", 6);
// PDF::MultiCell(15.83, 6, "YES", 'RBT', 'C', 0, 0, '', '', true);
// PDF::SetFont("freesans", "B", 6);
// PDF::MultiCell(15.83, 6, "Cooler", 'LBT', 'C', 1, 0, '', '', true);
// PDF::SetFont("freesans", "", 6);
// PDF::MultiCell(15.83, 6, "YES", 'RBT', 'C', 0, 0, '', '', true);

PDF::Ln(6);
PDF::SetFont("freesans", "B", 6);
PDF::MultiCell(31.66, 6, "Airflow [m3/min]", 'LTB', 'C', 1, 0, '', '', true);
PDF::SetFont("freesans", "", 6);
PDF::MultiCell(31.66, 6, "123", 'RTB', 'C', 0, 0, '', '', true);
PDF::SetFont("freesans", "", 6);
PDF::MultiCell(63.33, 6, "Comments", 'LT', 'L', 0, 0, '', '', true);
PDF::MultiCell(63.33, 6, "", 'TR', 'L', 0, 0, '', '', true);

PDF::Ln(6);
PDF::SetFont("freesans", "B", 6);
PDF::MultiCell(31.66, 6, "Separator", 'LTB', 'C', 1, 0, '', '', true);
PDF::SetFont("freesans", "", 6);
PDF::MultiCell(31.66, 6, "YES", 'RTB', 'C', 0, 0, '', '', true);
PDF::MultiCell(63.33, 6, "", 'L', 'L', 0, 0, '', '', true);
PDF::MultiCell(63.33, 6, "", 'R', 'L', 0, 0, '', '', true);

PDF::Ln(6);
PDF::SetFont("freesans", "B", 6);
PDF::MultiCell(31.66, 6, "Cooler [m3/min]", 'LTB', 'C', 1, 0, '', '', true);
PDF::SetFont("freesans", "", 6);
PDF::MultiCell(31.66, 6, "YES", 'RTB', 'C', 0, 0, '', '', true);
PDF::MultiCell(63.33, 6, "", 'L', 'L', 0, 0, '', '', true);
PDF::MultiCell(63.33, 6, "", 'R', 'L', 0, 0, '', '', true);



PDF::Ln(6);
PDF::setCellPaddings(1,1,1,1);
PDF::MultiCell(63.33, 17, "Reception", 'LTRB', 'L', 0, 0, '', '', true);
PDF::setCellPaddings(0,9,0,0);
PDF::MultiCell(63.33, 17, "--------------------------------\ncompany's data/rubber stamp", 1, 'C', 0, 0, '', '', true);
PDF::MultiCell(63.33, 17, "--------------------------------\ndate, legible signature", 1, 'C', 0, 0, '', '', true);


PDF::setPrintHeader(true);
PDF::setPrintFooter(true);
PDF::setHeaderFont(array("freesans", "", 9));
PDF::SetHeaderData('', '', 'Document Title', 'Document Header Text');
PDF::AddPage();


PDF::SetMargins(10, 0, 0, 0);
PDF::SetY(36);
PDF::SetX(10);


PDF::setCellPaddings( 1,1,1,1);
PDF::SetLineStyle(array('width' => 0.2, 'color' => array(0, 0, 0)));
for ($i=0; $i<40; $i++) {
    PDF::MultiCell(18.5, 0, $i+200, 1, 'C', 0, 0, '', '', true);
    PDF::MultiCell(18.5, 0, "10:10", 1, 'C', 0, 0, '', '', true);
    PDF::MultiCell(18.5, 0, "0:0", 1, 'C', 0, 0, '', '', true);
    PDF::MultiCell(18.5, 0, $i+10, 1, 'C', 0, 0, '', '', true);
    PDF::MultiCell(18.5, 0, "15:05:03", 1, 'C', 0, 0, '', '', true);
    PDF::MultiCell(5, 0, "",      0, 'C', 0, 0, '', '', true);
    PDF::MultiCell(18.5, 0, $i+200, 1, 'C', 0, 0, '', '', true);
    PDF::MultiCell(18.5, 0, "10:10", 1, 'C', 0, 0, '', '', true);
    PDF::MultiCell(18.5, 0, "0:0", 1, 'C', 0, 0, '', '', true);
    PDF::MultiCell(18.5, 0, $i+10, 1, 'C', 0, 0, '', '', true);
    PDF::MultiCell(18.5, 0, "15:05:03", 1, 'C', 0, 1, '', '', true); // jdynka oznacza ln=true czyli enter
    
}



// 180
// 5*15=75
//75



// -----------------------------------------------------------------------------



/*

// add a page
PDF::AddPage();

PDF::Write(0, 'Example of HTML tables', '', 0, 'L', true, 0, false, false, 0);

PDF::SetFont('opensans', '', 8);

// -----------------------------------------------------------------------------

$tbl = <<<EOD
<table cellspacing="0" cellpadding="1" border="1">
    <tr>
        <td rowspan="3">COL 1 - ROW 1<br />COLSPAN 3</td>
        <td>COL 2 - ROW 1</td>
        <td>COL 3 - ROW 1</td>
    </tr>
    <tr>
        <td rowspan="2">COL 2 - ROW 2 - COLSPAN 2<br />text line<br />text line<br />text line<br />text line</td>
        <td>COL 3 - ROW 2</td>
    </tr>
    <tr>
       <td>COL 3 - ROW 3</td>
    </tr>

</table>
EOD;

PDF::writeHTML($tbl, true, false, false, false, '');

// -----------------------------------------------------------------------------

$tbl = <<<EOD
<table cellspacing="0" cellpadding="1" border="1">
    <tr>
        <td rowspan="3">COL 1 - ROW 1<br />COLSPAN 3<br />text line<br />text line<br />text line<br />text line<br />text line<br />text line</td>
        <td>COL 2 - ROW 1</td>
        <td>COL 3 - ROW 1</td>
    </tr>
    <tr>
        <td rowspan="2">COL 2 - ROW 2 - COLSPAN 2<br />text line<br />text line<br />text line<br />text line</td>
         <td>COL 3 - ROW 2</td>
    </tr>
    <tr>
       <td>COL 3 - ROW 3</td>
    </tr>

</table>
EOD;

PDF::writeHTML($tbl, true, false, false, false, '');

// -----------------------------------------------------------------------------

$tbl = <<<EOD
<table cellspacing="0" cellpadding="1" border="1">
    <tr>
        <td rowspan="3">COL 1 - ROW 1<br />COLSPAN 3<br />text line<br />text line<br />text line<br />text line<br />text line<br />text line</td>
        <td>COL 2 - ROW 1</td>
        <td>COL 3 - ROW 1</td>
    </tr>
    <tr>
        <td rowspan="2">COL 2 - ROW 2 - COLSPAN 2<br />text line<br />text line<br />text line<br />text line</td>
         <td>COL 3 - ROW 2<br />text line<br />text line</td>
    </tr>
    <tr>
       <td>COL 3 - ROW 3</td>
    </tr>

</table>
EOD;

PDF::writeHTML($tbl, true, false, false, false, '');

// -----------------------------------------------------------------------------

$tbl = <<<EOD
<table border="1">
<tr>
<th rowspan="3">Left column</th>
<th colspan="5">Heading Column Span 5</th>
<th colspan="9">Heading Column Span 9</th>
</tr>
<tr>
<th rowspan="2">Rowspan 2<br />This is some text that fills the table cell.</th>
<th colspan="2">span 2</th>
<th colspan="2">span 2</th>
<th rowspan="2">2 rows</th>
<th colspan="8">Colspan 8</th>
</tr>
<tr>
<th>1a</th>
<th>2a</th>
<th>1b</th>
<th>2b</th>
<th>1</th>
<th>2</th>
<th>3</th>
<th>4</th>
<th>5</th>
<th>6</th>
<th>7</th>
<th>8</th>
</tr>
</table>
EOD;

PDF::writeHTML($tbl, true, false, false, false, '');

// -----------------------------------------------------------------------------

// Table with rowspans and THEAD
$tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2">
<thead>
 <tr style="background-color:#FFFF00;color:#0000FF;">
  <td width="30" align="center"><b>A</b></td>
  <td width="140" align="center"><b>XXXX</b></td>
  <td width="140" align="center"><b>XXXX</b></td>
  <td width="80" align="center"> <b>XXXX</b></td>
  <td width="80" align="center"><b>XXXX</b></td>
  <td width="45" align="center"><b>XXXX</b></td>
 </tr>
 <tr style="background-color:#FF0000;color:#FFFF00;">
  <td width="30" align="center"><b>B</b></td>
  <td width="140" align="center"><b>XXXX</b></td>
  <td width="140" align="center"><b>XXXX</b></td>
  <td width="80" align="center"> <b>XXXX</b></td>
  <td width="80" align="center"><b>XXXX</b></td>
  <td width="45" align="center"><b>XXXX</b></td>
 </tr>
</thead>
 <tr>
  <td width="30" align="center">1.</td>
  <td width="140" rowspan="6">XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX</td>
  <td width="140">XXXX<br />XXXX</td>
  <td width="80">XXXX<br />XXXX</td>
  <td width="80">XXXX</td>
  <td align="center" width="45">XXXX<br />XXXX</td>
 </tr>
 <tr>
  <td width="30" align="center" rowspan="3">2.</td>
  <td width="140" rowspan="3">XXXX<br />XXXX</td>
  <td width="80">XXXX<br />XXXX</td>
  <td width="80">XXXX<br />XXXX</td>
  <td align="center" width="45">XXXX<br />XXXX</td>
 </tr>
 <tr>
  <td width="80">XXXX<br />XXXX<br />XXXX<br />XXXX</td>
  <td width="80">XXXX<br />XXXX</td>
  <td align="center" width="45">XXXX<br />XXXX</td>
 </tr>
 <tr>
  <td width="80" rowspan="2" >RRRRRR<br />XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX</td>
  <td width="80">XXXX<br />XXXX</td>
  <td align="center" width="45">XXXX<br />XXXX</td>
 </tr>
 <tr>
  <td width="30" align="center">3.</td>
  <td width="140">XXXX1<br />XXXX</td>
  <td width="80">XXXX<br />XXXX</td>
  <td align="center" width="45">XXXX<br />XXXX</td>
 </tr>
 <tr>
  <td width="30" align="center">4.</td>
  <td width="140">XXXX<br />XXXX</td>
  <td width="80">XXXX<br />XXXX</td>
  <td width="80">XXXX<br />XXXX</td>
  <td align="center" width="45">XXXX<br />XXXX</td>
 </tr>
</table>
EOD;

PDF::writeHTML($tbl, true, false, false, false, '');

PDF::writeHTML($tbl, true, false, false, false, '');

// -----------------------------------------------------------------------------

// NON-BREAKING TABLE (nobr="true")

$tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2" nobr="true">
 <tr>
  <th colspan="3" align="center">NON-BREAKING TABLE</th>
 </tr>
 <tr>
  <td>1-1</td>
  <td>1-2</td>
  <td>1-3</td>
 </tr>
 <tr>
  <td>2-1</td>
  <td>3-2</td>
  <td>3-3</td>
 </tr>
 <tr>
  <td>3-1</td>
  <td>3-2</td>
  <td>3-3</td>
 </tr>
</table>
EOD;

PDF::writeHTML($tbl, true, false, false, false, '');

// -----------------------------------------------------------------------------

// NON-BREAKING ROWS (nobr="true")

$tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2" align="center">
 <tr nobr="true">
  <th colspan="3">NON-BREAKING ROWS</th>
 </tr>
 <tr nobr="true">
  <td>ROW 1<br />COLUMN 1</td>
  <td>ROW 1<br />COLUMN 2</td>
  <td>ROW 1<br />COLUMN 3</td>
 </tr>
 <tr nobr="true">
  <td>ROW 2<br />COLUMN 1</td>
  <td>ROW 2<br />COLUMN 2</td>
  <td>ROW 2<br />COLUMN 3</td>
 </tr>
 <tr nobr="true">
  <td>ROW 3<br />COLUMN 1</td>
  <td>ROW 3<br />COLUMN 2</td>
  <td>ROW 3<br />COLUMN 3</td>
 </tr>
</table>
EOD;

PDF::writeHTML($tbl, true, false, false, false, '');
*/


/*
// add a page
PDF::AddPage();

PDF::Text(5, 4, 'Line examples');
$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => '10,20,5,10', 'phase' => 10, 'color' => array(255, 0, 0));
$style2 = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 0, 0));
$style3 = array('width' => 1, 'cap' => 'round', 'join' => 'round', 'dash' => '2,10', 'color' => array(255, 0, 0));
$style4 = array('L' => 0,
                'T' => array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => '20,10', 'phase' => 10, 'color' => array(100, 100, 255)),
                'R' => array('width' => 0.50, 'cap' => 'round', 'join' => 'miter', 'dash' => 0, 'color' => array(50, 50, 127)),
                'B' => array('width' => 0.75, 'cap' => 'square', 'join' => 'miter', 'dash' => '30,10,5,10'));
$style5 = array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 64, 128));
$style6 = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => '10,10', 'color' => array(0, 128, 0));
$style7 = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 128, 0));

// Line
PDF::Text(5, 4, 'Line examples');
PDF::Line(5, 10, 80, 30, $style);
PDF::Line(5, 10, 5, 30, $style2);
PDF::Line(5, 10, 80, 10, $style3);

// Rect
PDF::Text(100, 4, 'Rectangle examples');
PDF::Rect(100, 10, 40, 20, 'DF', $style4, array(220, 220, 200));
PDF::Rect(145, 10, 40, 20, 'D', array('all' => $style3));

// Curve
PDF::Text(5, 34, 'Curve examples');
PDF::Curve(5, 40, 30, 55, 70, 45, 60, 75, null, $style6);
PDF::Curve(80, 40, 70, 75, 150, 45, 100, 75, 'F', $style6);
PDF::Curve(140, 40, 150, 55, 180, 45, 200, 75, 'DF', $style6, array(200, 220, 200));

// Circle and ellipse
PDF::Text(5, 79, 'Circle and ellipse examples');
PDF::SetLineStyle($style5);
PDF::Circle(25,105,20);
PDF::Circle(25,105,10, 90, 180, null, $style6);
PDF::Circle(25,105,10, 270, 360, 'F');
PDF::Circle(25,105,10, 270, 360, 'C', $style6);

PDF::SetLineStyle($style5);
PDF::Ellipse(100,103,40,20);
PDF::Ellipse(100,105,20,10, 0, 90, 180, null, $style6);
PDF::Ellipse(100,105,20,10, 0, 270, 360, 'DF', $style6);

PDF::SetLineStyle($style5);
PDF::Ellipse(175,103,30,15,45);
PDF::Ellipse(175,105,15,7.50, 45, 90, 180, null, $style6);
PDF::Ellipse(175,105,15,7.50, 45, 270, 360, 'F', $style6, array(220, 200, 200));

// Polygon
PDF::Text(5, 129, 'Polygon examples');
PDF::SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
PDF::Polygon(array(5,135,45,135,15,165));
PDF::Polygon(array(60,135,80,135,80,155,70,165,50,155), 'DF', array($style6, $style7, $style7, 0, $style6), array(220, 200, 200));
PDF::Polygon(array(120,135,140,135,150,155,110,155), 'D', array($style6, 0, $style7, $style6));
PDF::Polygon(array(160,135,190,155,170,155,200,160,160,165), 'DF', array('all' => $style6), array(220, 220, 220));

// Polygonal Line
PDF::SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 164)));
PDF::PolyLine(array(80,165,90,160,100,165,110,160,120,165,130,160,140,165), 'D', array(), array());

// Regular polygon
PDF::Text(5, 169, 'Regular polygon examples');
PDF::SetLineStyle($style5);
PDF::RegularPolygon(20, 190, 15, 6, 0, 1, 'F');
PDF::RegularPolygon(55, 190, 15, 6);
PDF::RegularPolygon(55, 190, 10, 6, 45, 0, 'DF', array($style6, 0, $style7, 0, $style7, $style7));
PDF::RegularPolygon(90, 190, 15, 3, 0, 1, 'DF', array('all' => $style5), array(200, 220, 200), 'F', array(255, 200, 200));
PDF::RegularPolygon(125, 190, 15, 4, 30, 1, null, array('all' => $style5), null, null, $style6);
PDF::RegularPolygon(160, 190, 15, 10);

// Star polygon
PDF::Text(5, 209, 'Star polygon examples');
PDF::SetLineStyle($style5);
PDF::StarPolygon(20, 230, 15, 20, 3, 0, 1, 'F');
PDF::StarPolygon(55, 230, 15, 12, 5);
PDF::StarPolygon(55, 230, 7, 12, 5, 45, 0, 'DF', array('all' => $style7), array(220, 220, 200), 'F', array(255, 200, 200));
PDF::StarPolygon(90, 230, 15, 20, 6, 0, 1, 'DF', array('all' => $style5), array(220, 220, 200), 'F', array(255, 200, 200));
PDF::StarPolygon(125, 230, 15, 5, 2, 30, 1, null, array('all' => $style5), null, null, $style6);
PDF::StarPolygon(160, 230, 15, 10, 3);
PDF::StarPolygon(160, 230, 7, 50, 26);

// Rounded rectangle
PDF::Text(5, 249, 'Rounded rectangle examples');
PDF::SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
PDF::RoundedRect(5, 255, 40, 30, 3.50, '1111', 'DF');
PDF::RoundedRect(50, 255, 40, 30, 6.50, '1000');
PDF::RoundedRect(95, 255, 40, 30, 10.0, '1111', null, $style6);
PDF::RoundedRect(140, 255, 40, 30, 8.0, '0101', 'DF', $style6, array(200, 200, 200));

// Arrows
PDF::Text(185, 249, 'Arrows');
PDF::SetLineStyle($style5);
PDF::SetFillColor(255, 0, 0);
PDF::Arrow(200, 280, 185, 266, 0, 5, 15);
PDF::Arrow(200, 280, 190, 263, 1, 5, 15);
PDF::Arrow(200, 280, 195, 261, 2, 5, 15);
PDF::Arrow(200, 280, 200, 260, 3, 5, 15);

// - . - . - . - . - . - . - . - . - . - . - . - . - . - . -

// ellipse

// add a page
PDF::AddPage();

PDF::Cell(0, 0, 'Arc of Ellipse');

// center of ellipse
$xc=100;
$yc=100;

// X Y axis
PDF::SetDrawColor(200, 200, 200);
PDF::Line($xc-50, $yc, $xc+50, $yc);
PDF::Line($xc, $yc-50, $xc, $yc+50);

// ellipse axis
PDF::SetDrawColor(200, 220, 255);
PDF::Line($xc-50, $yc-50, $xc+50, $yc+50);
PDF::Line($xc-50, $yc+50, $xc+50, $yc-50);

// ellipse
PDF::SetDrawColor(200, 255, 200);
PDF::Ellipse($xc, $yc, 30, 15, 45, 0, 360, 'D', array(), array(), 2);

// ellipse arc
PDF::SetDrawColor(255, 0, 0);
PDF::Ellipse($xc, $yc, 30, 15, 45, 45, 90, 'D', array(), array(), 2);


// ---------------------------------------------------------
*/
//Close and output PDF document
PDF::Output('example_012.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+








    }

    public function index() 
    {
        $html = '<h1 style="color:red;">Hello World</h1>';
        
        PDF::SetTitle('Hello World');
        PDF::AddPage();
        PDF::writeHTML($html, true, false, true, false, '');

        PDF::Output('hello_world.pdf');
    }

}
