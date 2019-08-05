<?php 
$idFirma=$_GET['x'];
$numeroEmpleado=$_GET['proce'];

//require('../fpdf/fpdf.php');
require('../fpdf/WriteTag.php');
require('ConversionSueldo.php');
require('ConversionFecha.php');
include('../crearConexionVam.php'); 
$mostrarDatos=mssql_query("SELECT * FROM prempy  WHERE cempno='$numeroEmpleado'");
if ($row=mssql_fetch_array($mostrarDatos)) {
    $DESC=$row['cfedid'];
    $codigoPuesto=$row['cjobtitle'];
    $codigoAsignado=$row['cdeptno'];
    $opnetersueldo=$row['nmonthpay'];
    $nombre=trim($row['cfname']);
    $apellido=trim($row['clname']);
    //echo "<script>alert('".$DESC."');</script>";

   $dia1 = date("d", strtotime($row['dhire']));
   $mes1 = date("m", strtotime($row['dhire']));
   $anio1 = date("Y", strtotime($row['dhire']));

   $dia2 = date("d", strtotime($row['dcntrct']));
   $mes2 = date("m", strtotime($row['dcntrct']));
   $anio2 = date("Y", strtotime($row['dcntrct']));
 
   $fechaContrato=fecha($dia1,$mes1,$anio1); 
   $fechaAcuerdo=fecha($dia2,$mes2,$anio2); 

  if ($row['dhire']==$row['dcntrct']) {
    $msg="HA LABORADO POR ACURDO EN ESTA INSTITUCION A PARTIR DEL ".$fechaContrato.", ";
  }
  if ($row['dhire']>$row['dcntrct']) {
    $msg="HA LABORADO POR CONTRATO EN ESTA INSTITUCION APARTIR DE ".$fechaContrato." Y POR ACUERDO DESDE EL ".$fechaAcuerdo.",";
  }
$var=convertir($opnetersueldo);
$formato=number_format($opnetersueldo,2);


$mostrarDesc=mssql_query("SELECT * FROM hrjobs WHERE cJobTitlNO='$codigoPuesto'");
if ($ejecutar=mssql_fetch_array($mostrarDesc)) {
    $desempenio=trim($ejecutar['cDesc']);
    $desemp=strtolower($desempenio);
    $desempenio=ucwords($desemp);
}
$mostrarDesc=mssql_query("SELECT * FROM prdept WHERE cdeptno='$codigoAsignado'");
if ($asignado=mssql_fetch_array($mostrarDesc)) {
    $asignacion=trim($asignado['cdeptname']);
     $asignacion_minuscula=strtolower($asignacion);
    $asignacion=ucwords($asignacion_minuscula);
}


    
}
$dia=date("d");
$mes=date("m");
$anio=date("Y");
$fechaActual=fecha1($dia,$mes,$anio); 

include('../crearConexionGECOMP.php');
$mostrarDato=mssql_query("SELECT * FROM FIRMA_CONSTANCIAS WHERE Id_FIRMA='$idFirma'");
if ($firma=mssql_fetch_array($mostrarDato)) {
  $nombreFirma=$firma['NOMBRE_EMPLEADO'];

  $FrimaCons=strtolower($nombreFirma);
  $nombreFirma=ucwords($FrimaCons);
  $puestoFirma=$firma['PUESTO_EMPLEADO'];
}


class PDF extends PDF_WriteTag
{
// Page header
function Header()
{
    // Logo
    $this->Image('../img/9.png',70,6,75);
    // Arial bold 15
    $this->SetFont('Times','B',14);
    // Move to the right
    $this->Ln(40);
    $this->Cell(72);
    // Title

    $this->Cell(45,0,'CONSTANCIA',0,0,'C');
    // Line break
    $this->Ln(20);
}

// Page footer
function Footer()
{
      // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->SetLineWidth(0);
    //$this->Line(20,280,190,280);
    $this->Cell(0,0,'Edificio Lomas Plaza II, Lomas del guijaro, Avenida Republica Dominicana, Tegucigalpa D.M.C, Honduras C.A 1',0,0,'C');
    $this->Ln();
    $this->Cell(0,10,'apartado postal No, 3730, Tel:(504)2221-3099, FAX:(504)2221-5667',0,0,'C');
}

}

// Instanciation of inherited class


$pdf=new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',13);
$pdf->SetLeftMargin(18); #Establecemos los márgenes izquierda: 
$pdf->SetRightMargin(18); #Establecemos los márgenes Derecha: 


// Stylesheet
$pdf->SetStyle("p","Arial","",12,"0,0,0",0);
$pdf->SetStyle("h1","arial","N",12,"0,0,0",0);
$pdf->SetStyle("a","arial","BU",12,"0,0,0");
$pdf->SetStyle("pers","arial","I",0,"0,0,0");
$pdf->SetStyle("place","arial","U",0,"0,0,0");
$pdf->SetStyle("vb","arial","B",0,"0,0,0");



$pdf->Ln(5);

//  Ñ  ñ  ó
$txt=utf8_encode($nombre)." ".utf8_encode($apellido);
$nombreEmp=strtolower($txt);
$txt="<vb>".ucwords($nombreEmp)."</vb>";



$texto = "El (a) Suscrito ".utf8_encode($puestoFirma)." del ministerio publico hace constar que ".$txt." ha laborado por contrato en esta institucion a partir del ".$fechaContrato." y por acuerdo el ".$fechaAcuerdo.", actualmente se desempeña como: \t".trim($desempenio)."\t"." asignado a: ".utf8_encode($asignacion).", devengando un sueldo mensual de: \t".$var."\t"." (L.".$formato.").";

//$texto = "El (a) Suscrito ".utf8_encode($puestoFirma)." DEL MINISTERIO PUBLICO HACE CONSTAR QUE ".$txt." HA LABORADO POR CONTRATO EN ESTA INSTITUCION A PARTIR DEL ".$fechaContrato." Y POR ACUERDO DESDE EL ".$fechaAcuerdo.", ACTUALMENTE SE DESEMPEÑA COMO: \t".trim($desempenio)."\t"." ASIGNADO A: ".utf8_encode($asignacion).", DEVENGANDO UN SUELDO MENSUAL DE: \t".$var."\t"." (".$formato.").";




$pdf->WriteTag(0,7,utf8_decode($texto),0,"J",0,0);




$pdf->Cell(10,20,'',0,1,'C'); 
$texto1="Constancia que se expide a petición de parte interesada, en la ciudad de Tegucigalpa, Municipio Central, a ".$fechaActual."";
$pdf->WriteTag(0,7,utf8_decode($texto1),0,"J",0,0);

$pdf->line();  
$pdf->Cell(10,50,'',0,1,'C'); 
$pdf->Cell(172,5,'_______________________________',0,1,'C');
$pdf->Cell(10,3,'',0,1,'C');
$pdf->Cell(172,7,utf8_encode($nombreFirma),0,1,'C');
$pdf->Cell(10,0,'',0,1,'C');
$pdf->Cell(172,5,$puestoFirma,0,1,'C');

// Signature


 

//$pdf->line(40, 10, 80, 10);
//$pdf->InsertText("\n\n"); 

$pdf->Output();
?>