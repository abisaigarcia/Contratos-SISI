<?php

define('FPDF_FONTPATH','../scripts/font');
require('fpdf.php');

////////Funciones
function NEstados($Edo){
     If ($Edo== "AGSC"){
         return "AGUASCALIENTES";
     }
     If ($Edo== "QROO"){
         return "QUINTANA ROO";
     }
     
     If ($Edo== "EDOM"){
         return "ESTADO DE MEXICO";
     }
     If ($Edo== "CHIH"){
         return "CHIHUAHUA";
     }
     If ($Edo== "COAH"){
         return "COAHUILA";
     }
     If ($Edo== "COLIMA"){
         return "COLIMA";
     }
     If ($Edo== "DF"){
         return "DISTRITO FEDERAL";
     }
     If ($Edo== "DURG"){
         return "DURANGO";
     }
     If ($Edo== "GUAN"){
         return "GUANAJUATO";
     }
     If ($Edo== "GUER"){
         return "GUERRERO";
     }
     If ($Edo== "HIDA"){
         return "HIDALGO";
     }
     If ($Edo== "JALI"){
         return "JALISCO";
     }
     If ($Edo== "MICH"){
         return "MICHOACAN";
     }
     If ($Edo== "MORE"){
         return "MORELOS";
     }
     If ($Edo== "NAYA"){
         return "NAYARIT";
     }
     If ($Edo== "NVOL"){
         return "NUEVO LEON";
     }
     If ($Edo== "OAX"){
         return "OAXACA";
     }
     If ($Edo== "PUE"){
         return "PUEBLA";
     }
     If ($Edo== "QRO"){
         return "QUERETARO";
     }
     If ($Edo== "SIN"){
         return "SINALOA";
     }
     If ($Edo== "SLP"){
         return "SAN LUIS POTOSI";
     }
     If ($Edo== "TAB"){
         return "TABASCO";
     }
     If ($Edo== "SON"){
         return "SONORA";
     }
     If ($Edo== "TAML"){
         return "TAMAULIPAS";
     }
     If ($Edo== "TLAX"){
         return "TLAXCALA";
     }
     If ($Edo== "VER"){
         return "VERACRUZ";
     }
     If ($Edo== "YUC"){
         return "YUCATAN";
     }
     If ($Edo== "ZAC"){
         return "ZACATECAS";
     }
}
////////////////////////////../PHP/certificado.php
     
//create an instance of the  ADO connection object
$conn = new COM ("ADODB.Connection")
  or die("Cannot start ADO");

//define connection string, specify database driver
//$connStr = "Microsoft.ACE.OLEDB.12.0;Data Source=D:\inetpub\wwwroot\Dropbox\BDs\Arrendamientos.mdb";
//Siteserver//$connStr = "Provider=Microsoft.Jet.OLEDB.4.0;Data Source=D:\Domains\ventayrenta.info\database\Arrendamientos.mdb";
 $connStr = "provider= Microsoft.ACE.OLEDB.12.0;Data Source=D:\inetpub\wwwroot\Dropbox\BDs\Arrendamientos.mdb";
  $conn->open($connStr); //Open the connection to the database

//declare the SQL statement that will query the database
$query = "SELECT r.*, a.CalleYNumeroDelDomicilio, a.Colonia, a.CodigoPostal, a.DelegacionOMunicipio, a.Ciudad, a.Estado, a.GiroDelInmuebleArrendado, a.PropietarioCve, a.estado FROM registro_proteccion r, arrendamientos a WHERE r.arrcve=a.arrcve AND r.REGCVE='".$_REQUEST['arrcve']."' AND r.NoAutorizacion=".$_REQUEST['NoAutorizacion'];
//echo($query."<p>");

//execute the SQL statement and return records
$rs = $conn->execute($query); 

IF(!$rs->EOF){
    //echo $query;
    
   $num_columns = $rs->Fields->Count();
    //echo($num_columns);

   for ($i=0; $i < $num_columns; $i++) {
         $fld[$i] = $rs->Fields($i);
    }
     
       $Gtomadeposecion="15,000.00";
             $diasN="20";
    
       $calle=ucwords(strtolower($fld[48]->value));
       $Colonia=ucwords(strtolower($fld[49]->value));
       $Del_Mun= ucwords(strtolower($fld[51]->value));
       $Estado=ucwords(strtolower(NEstados($fld[53]->value)));
       $CP=$fld[50]->value;
       $GiroInm=$fld[54]->value;
       $PaqCob=$fld[12]->value;
          if($PaqCob=="CJUD"){
             $Gtomadeposecion="10,000.00";
             $diasN="10";
          }ElseIf($PaqCob=="ESEN"){
              $Gtomadeposecion="10,000.00";
              $diasN="10";
          }ElseIf($PaqCob=="BASI"){
              $Gtomadeposecion="15,000.00";
              $diasN="15";
          }ElseIf($PaqCob=="COMPp"){
              $Gtomadeposecion="25,000.00";
              $diasN="20";
          }
       $inm_cve=$fld[13]->value;
       $renta=$fld[7]->value;
       $Ldañofisico="0";
       $LRentas="0";
       $LDanos3="0";
       
       
       
     //////////////////////////////////////////////////////Query2
    
     $query2 = "SELECT * from Directorio  where DIRCVE=".$fld[55]->value;

     //execute the SQL statement and return records
     $rs2 = $conn->execute($query2);
     //echo $query;

     IF(!$rs2->EOF){
        $num_columns2 = $rs2->Fields->Count(); 
        for ($i=0; $i < $num_columns2; $i++) {
           $fld2[$i] = $rs2->Fields($i);
         }
        $Genero=$fld2[19]->value;
		$TP=$fld2[14]->value;
		if($TP=-1){
		   $RS_arrendador=$fld2[5]->value." ".$fld2[2]->value." ".$fld2[3]->value." ".$fld2[4]->value;
		   //$RS_arrendador="Persona fisica";
		}else{
		   $RS_arrendador=$fld2[13]->value;
		   //$RS_arrendador="Persona Moral";
		}
		
        
		
        $calle_arrendador=ucwords(strtolower($fld2[6]->value)." ".strtolower($fld2[7]->value)." ".strtolower($fld2[8]->value));
        $colonia_arrendador=ucwords(strtolower($fld2[9]->value));
        $delegacion_arrendador=ucwords(strtolower($fld2[10]->value));
        $estado_arrendador=ucwords(strtolower($fld2[11]->value));
        $CP_arrendador=$fld2[12]->value;
        
       }
	      $genET= "el";
	   if($Genero=="M"){
	      $genET= "el";
	   }Else{
	      $genET= "la";
	   }
	   
     
     //////////////////////////////////////////////////////
       
     //////////////////////////////////////////////////////Query 3
     
       $query3 = "SELECT * FROM arrendamientos WHERE ARRCVE='".$fld[0]->value."'";

        //execute the SQL statement and return records
       $rs3 = $conn->execute($query3);
//       echo $query3;

      IF(!$rs3->EOF){
       $num_columns3 = $rs3->Fields->Count(); 
        for ($i=0; $i < $num_columns3; $i++) {
           $fld3[$i] = $rs3->Fields($i);
         }
         
        
         //$inivigencia=$fld3[27]->value;
         //$inivigencia=date("d/m/Y",$inivigencia);
         //$finvigencia=$fld3[29]->value;
         //$finvigencia=date("d/m/Y",$invigencia);
		 
		 //$inivigencia2=date("d/m/Y",$inivigencia);
		 
		 
		 //////$inivigencia= $fld3[27]->value;
		 
		 
		 
		$inivigencia1= new DateTime($fld3[27]->value);
		$inivigencia=$inivigencia1->format("d/m/Y");
		 
		 //$inivigencia1="01/01/2014";
		 

//$finvigencia= $fld3[29]->value;
                 
                 
		$finvigencia1= new DateTime($fld3[29]->value);
		$finvigencia=$finvigencia1->format("d/m/Y");
                 
                 //$finvigencia="01/01/2015";
		 
         $vigencia="Del ".$inivigencia." al ".$finvigencia;
         $ExtDominio=$fld3[48]->value;
       }
      
     //////////////////////////////////////////////////
       
       
     
     ////////////////////////////////////// query4
         $query4 = "SELECT * FROM paq_coberturas WHERE paqcve='".$PaqCob."'";

        //execute the SQL statement and return records
       $rs4 = $conn->execute($query4);
//       echo $query3;

      IF(!$rs4->EOF){
       $num_columns4 = $rs4->Fields->Count(); 
        for ($i=0; $i < $num_columns4; $i++) {
           $fld4[$i] = $rs4->Fields($i);
         }
         
         $GJudiciales=$fld4[4]->value;
         $Danos=$fld4[3]->value;
//         $Danos=false;
//         $GJudiciales=true;
//         $ExtDominio=true;
        
         
        
       }
       
     ////////////////////////////////////////////////////77777
    
    if ($Danos == true){   
     //////////////////////////////////////////////////7query 5
     
       $query5 = "SELECT * FROM tipos_inmueble WHERE inmcve='".$inm_cve."'";

     //execute the SQL statement and return records
     $rs5 = $conn->execute($query5);
     //echo $query;

     IF(!$rs5->EOF){
        $num_columns5 = $rs5->Fields->Count(); 
        for ($i=0; $i < $num_columns5; $i++) {
           $fld5[$i] = $rs5->Fields($i);
         }

       //echo "se encontro tipo de inmueble";
        $meses_sa=$fld5[4]->value;
        $sa_max_da=$fld5[6]->value;
        $sa_max_rentas=$fld5[8]->value;
        $sa_max_rc=$fld5[7]->value;
        
        //echo "(".$meses_sa.",".$sa_max_da.")";
        $LdañofisicoEdif=$renta * $meses_sa;
        //echo number_format(2.2467, 2, ',');
        If ( $Ldañofisico > $sa_max_da){
            $Ldañofisico=number_format($sa_max_da,2);
        }Else{
            $Ldañofisico=number_format($LdañofisicoEdif,2);
            }
            
            
            
           $rentas= $renta* 12;
           if($rentas > $sa_max_rentas){
               
               $LRentas=number_format($sa_max_rentas,2);
           }Else{
               $LRentas=number_format($rentas,2);
               
           }
           
           
           
           $rc= $renta *100;
           if($rentas > $sa_max_rc){
               $LDanos3=number_format($sa_max_rc,2);
            }Else{
               $LDanos3=number_format($rc,2);   
            }
           
       }
     
       
       
       
       
      ///////////////////////////////////////////////////////////7
     
    }
     
     
     
     
     
}Else
    echo "<BR/><BR/><Center><B><FONT color=RED>No se encontro nigún Arrendamiento con el Número de Autorización solicitado.</Font></B></Center><BR/><Center><input type=submit value='Cerrar' onclick='javascript:window.close();' ><BR/><BR/>";
     
     

$fecha=time();
$N_Proteccion=strtoupper($_REQUEST['arrcve']);
$fechaAct=date("d/m/Y");


//$calle="Cerrada de Halcones No. 21 C";
//$Colonia="Las Alamedas";
//$Del_Mun= "Atizapan de Zaragoza";
//$Estado="Estado de México";
//$CP="52970";
//$GiroInm="CASA HABITACION";


//$Gtomadeposecion="15,000.00";


//$Danos=false;
//$GJudiciales=true;
//$ExtDominio=false;

//$RS_arrendador=$fld[54]->value;
//$calle_arrendador="Av. Insurgentes Sur No. 1605 2do. Nivel L-56";
//$colonia_arrendador="San José Insurgentes";
//$delegacion_arrendador="Benito juarez";
//$estado_arrendador="Distrito Federal";
//$CP_arrendador="55020";



$encabezado1="Gastos Judiciales";
$texto_Principal="Se pagarán los gastos y costas judiciales, a los abogados designados por El Prestador, del procedimiento de rescisión o terminación del contrato de arrendamiento sobre el inmueble descrito en las declaraciones, derivada del incumplimiento del inquilino a sus obligaciones establecidas en el contrato de arrendamiento.";


$texto_opcional2="
        
De igual forma quedan cubiertos los gastos y costas de defensa en caso de que las autoridades competentes apliquen al inmueble arrendado la extinción de dominio por actos criminales llevados a cabo por el inquilino.";


///if($GJudiciales==true){
   /// $texto_Principal=$texto_Principal.$texto_opcional2;
///}

$texto_Principal2="El Prestatario deberá rehusarse a hacer convenios modificatorios al contrato de arrendamiento sin haberlo consultado con El Prestador, las modificaciones hechas en esa forma rescindirán el presente contrato de prestación de servicios de pleno derecho sin necesidad de resolución judicial, sin mayor responsabilidad para las partes. Igualmente el incumplimiento de las siguientes obligaciones de El Prestatario tendrán el mismo efecto rescisorio.
    
Para iniciar una demanda de rescisión o terminación del contrato de arrendamiento, El Prestatario deberá otorgar poderes especiales de pleitos y cobranzas a los abogados que le indique El Prestador, quien cubrirá el costo de este poder hasta la cantidad indicada en este contrato.

En el momento de iniciar el proceso de demanda y a más tardar 15 días después de que le sea notificado por El Prestador, El Prestatario deberá ceder por escrito a EL Prestador los derechos de recuperación de los gastos y costas judiciales que El Prestador erogue durante el juicio. 

En caso de incumplimientos al contrato de arrendamiento, El Prestatario deberá notificar inmediatamente a El Prestador en su domicilio y seguir las instrucciones que se le indiquen. Es muy importante que no haga acuerdos, ni reciba documentos de promesa de pago antes de recibir asesoría de El Prestador.

El contrato establece que el inquilino requiere la autorización de El Prestatario de este certificado por escrito para hacer modificaciones al inmueble. En caso de que El Prestatario tenga conocimiento de que se llevan modificaciones al inmueble, deberá informarlo a El Prestador para recibir orientación. En caso de que el inquilino desee hacer algún cambio a la estructura del inmueble, El Prestador asesorará a El Prestatario sobre la conveniencia de hacerlo.";


$EncabezadoOp1="Cobertura de Daños";

$texto_opcional1="Para la obtención de esta cobertura El Prestador contratará, con la total aceptación de El Prestatario, la(s) póliza(s) de Seguro(s) adecuada(s) y suficientes para cumplir con la cobertura especificada en este documento, contratados con aseguradoras legalmente constituidas en México. La(s) póliza(s) mencionadas otorgarán la protección al inmueble objeto del arrendamiento al que se hace referencia en este contrato y a su propietario legal, hasta los límites señalados en este mismo contrato en los términos descritos en adelante. Por lo tanto El Prestatario acepta que el alcance descrito es enunciativo y las siguientes características son sólo descriptivas y que prevalecerán las condiciones especificadas en las pólizas respectivas.
    
Se pagarán los daños al inmueble por accidentes que no sean consecuencia de actos de la naturaleza, operaciones bélicas, actos de autoridad, reacción nuclear, dolo o mala fe del propietario y terrorismo y otras exclusiones establecidas en la póliza. También estarán cubiertos los daños por actos vandálicos del inquilino. No serán considerados actos vandálicos el deterioro del inmueble y sus instalaciones a causa del uso cotidiano.

Cuando el inmueble no pueda ser usado por el arrendatario debido a su destrucción total o parcial por las causas descritas en el párrafo anterior, la rentas serán pagadas por la aseguradora durante el tiempo que lleven los trabajos de reparación de los daños o de su reconstrucción.

Los daños que se causen a terceros incluyendo al inquilino que resulten responsabilidad del propietario por las cosas que emanen del inmueble, por sus vicios ocultos o por la falta de reparación oportuna serán pagados por la aseguradora hasta el límite establecido en este contrato. Si El Prestatario sospecha que el inmueble ha sufrido daños o éstos le son reportados por el inquilino, deberá reportar esos hechos a El Prestador para recibir asesoriá y para que sean verificados y cuantificados los daños.";


//$texto_opcional1="Para la obtención de estas protecciones El Prestador contratará, con la total aceptación de El Prestatario, la(s) póliza(s) de Seguro(s) adecuada(s) y suficientes para cumplir con la cobertura especificada en este documento. La(s) póliza(s) mencionadas son contratos independientes con aseguradoras legalmente constituidas. Por lo tanto El Prestatario acepta que el alcance descrito es enunciativo. En todo momento las coberturas estarán sujetas a las siguientes condiciones durante la vigencia de este contrato.
    
//Se pagarán los daños al inmueble por accidentes que no sean consecuencia de actos de la naturaleza, operaciones bélicas, actos de autoridad, reacción nuclear, dolo o mala fe del propietario y terrorismo. También estarán cubiertos los daños por actos vandálicos del inquilino. No serán considerados actos vandálicos el deterioro de las instalaciones o del mismo inmueble provocado por el uso cotidiano.
    
//Cuando el inmueble no pueda ser usado por el arrendatario debido a su destrucción total o parcial por las causas descritas en el párrafo anterior, la rentas serán pagadas por la aseguradora  durante el tiempo que lleven los trabajos de reparación de los daños.

//Los daños que se causen a terceros incluyendo al inquilino que resulten responsabilidad del propietario por las cosas que emanen del inmueble, por sus vicios ocultos o por la falta de reparación oportuna serán pagados por la aseguradora hasta el límite establecido en este contrato.";



//texto_principal3= gastos judiciales
$texto_opcional3="El Prestatario tendrá derecho a la defensa jurídica en materia civil en caso de que las autoridades competentes apliquen la ley de extinción de dominio en su contra a consecuencia de que el inquilino lleve a cabo actos ilícitos de los considerados en la mencionada ley, no obstante haber declarado en el contrato de arrendamiento que se dedica a actividades lícitas.";

$texto_Principal3="Si El Prestatario sospecha que el inquilino abandonó el inmueble, no deberá entrar al mismo, ya que estaría cometiendo un delito, debe notificar a El Prestador para recibir orientación y definir la mejor acción a seguir.
    
Los gastos originados por el lanzamiento o toma de posesión del inmueble después de que se obtengan las ordenes judiciales correspondientes, serán cubiertos por El Prestador hasta la cantidad indicada en este contrato, en caso de que por las características del inmueble sea necesario cubrir un gasto mayor, El Prestatario acepta cubrir esa diferencia."; 
   
  //if ($GJudiciales==True){
      
    //  $texto_Principal3="Para iniciar una demanda de rescisión o terminación del contrato de arrendamiento, El Prestatario deberá otorgar poderes especiales de pleitos y cobranzas a los abogados que le indique El Prestador, quien cubrirá el costo de este poder hasta la cantidad indicada en este contrato.";
     
 // }Else{
   //   $texto_Principal3= "Para iniciar una demanda de rescisión o terminación del contrato de arrendamiento, El Prestatario deberá otorgar poderes especiales de pleitos y cobranzas a los abogados que le indique El Prestador, quien cubrirá el costo de este poder hasta la cantidad indicada en este contrato.
          
//Los gastos originados por el lanzamiento o toma de posesión del inmueble después de que se obtengan las órdenes judiciales correspondientes, serán cubiertos por El Prestador hasta la cantidad indicada en este contrato, en caso de que por las características del inmueble sea necesario cubrir un gasto mayor, El Prestatario acepta cubrir esa diferencia.";
 // }

If ($ExtDominio==False){
    $texto_opcional3=" ";
}
//////////////////////////////////////////////////////////////////////Cración del PDF

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetAutoPageBreak(False);
$pdf->setFillColor(194,194,196);
$pdf->SetDrawColor(255,255,255);
$pdf->SetFont('Times','',10);
$pdf->Image('../images/certi.jpg',15,27,99,15);

///////// Inicia columna derecha
$pdf->SetFont('Arial','B',12);
$pdf->SetXY(140,20); 
$pdf->Cell(20,5,"Contrato de Prestación",0,0,'L');
$pdf->SetXY(155,25); 
$pdf->Cell(20,5,"de Servicios",0,0,'C');

$pdf->SetFont('Arial','B',11);
$pdf->SetXY(138,33); 
$pdf->Cell(26,5,"Fecha",1,0,'C',true);

$pdf->SetXY(165,33); 
$pdf->Cell(27,5,"Numero",1,0,'C',true);

$pdf->SetFont('Arial','',10);
$pdf->SetXY(138,38); 
$pdf->Cell(26,5,$fechaAct,1,0,'C');
$pdf->SetXY(165,38); 
$pdf->Cell(27,5,$N_Proteccion,1,0,'C');


$pdf->SetFont('Arial','B',11);
$pdf->SetXY(138,43); 
$pdf->Cell(54,5,"Lugar de Expedición",1,0,'C',true);
$pdf->SetFont('Arial','',10);
$pdf->SetXY(153,48); 
$pdf->Cell(27,5,"México D.F.",1,0,'C');


$pdf->SetFont('Arial','B',11);
$pdf->SetXY(138,56); 
$pdf->Cell(54,5,"Servicios Contratados",1,0,'C',true);
$pdf->SetFont('Arial','',10);
If ($Danos==true){
  $pdf->SetXY(138,63); 
  $pdf->MultiCell(54,3,"Seguro de Daños",1,'C');
}
//servicios opcionales
If ($GJudiciales==true){
  $pdf->SetXY(138,71); 
  $pdf->MultiCell(54,3,"Gastos Judiciales",1,'C');
}
If ($ExtDominio==true){
  $pdf->SetXY(138,79); 
  $pdf->MultiCell(54,3,"Extinción de Dominio",1,'C');
}
  //$pdf->SetXY(138,87); 
  //$pdf->MultiCell(54,3,"Contrtación de seguro de Daños para prueba 4",1,'C');

///////Terminan servicios


$pdf->SetFont('Arial','B',11);
$pdf->SetXY(138,98); 
$pdf->Cell(54,5,"Moneda",1,0,'C',true);
$pdf->SetXY(138,104); 
$pdf->SetFont('Arial','',10);
$pdf->MultiCell(54,3,"Pesos",1,'C');


$pdf->SetFont('Arial','B',11);
$pdf->SetXY(138,109); 
$pdf->Cell(54,5,"Vigencia del Contrato",1,0,'C',true);
$pdf->SetXY(138,116); 
$pdf->SetFont('Arial','',10);
$pdf->Cell(54,5,$vigencia,1,0,'C');

////////////////////////// Termina Columna Derecha




$pdf->SetFont('Arial','',11);
///////////////Inicia columna Izquierda

$pdf->SetXY(14,53); 
$pdf->MultiCell(118,4,"Contrato de Prestación de servicios entre Certi Net, S. de R. L. de C.V. en adelante “El Prestador” y ".$genET." ".$RS_arrendador." en adelante “El Prestatario” con relación al contrato de arrendamiento del inmueble descrito a continuación:",1,'J');

$pdf->SetFont('Arial','B',11);
$pdf->SetXY(14,78); 
$pdf->Cell(118,5,"Inmueble Ubicado en:",1,0,'L',true);


$pdf->SetFont('Arial','',11);
$pdf->SetXY(14,86); 
$pdf->MultiCell(118,4,"Calle ".$calle.", Colonia ".$Colonia.", ".$Del_Mun.",  ".$Estado.",  C.P. ".$CP,1,'J');
$pdf->SetXY(14,99); 
$pdf->MultiCell(118,5,"Giro del Inmueble: ".$GiroInm,1,'J');



////////////// Termina Columna derecha



///////////Inicia cuerpo principal
$pdf->SetLineWidth(.6);
$pdf->SetDrawColor(88,88,88);

If ($Danos==true){
    

   $pdf->SetXY(14,133); 
   $pdf->SetFont('Arial','B',10);
   $pdf->MultiCell(178,5,"Declara El Prestatario estar de acuerdo en que El Prestador contrate un seguro de todo riesgo y responsabilidad civil para cubrir el inmueble arrendado con los siguientes límites y condiciones:",1,'J');

   $pdf->SetXY(14,143); 
   $pdf->Cell(65,10,"Limites de la cobertura",1,0,'L',true);
   $pdf->SetXY(79,143); 
   $pdf->Cell(28,10,"Pesos",1,0,'L',true);
   $pdf->SetXY(107,143); 
   $pdf->Cell(85,10,"Deducibles",1,0,'L',true);

   $pdf->SetFont('Arial','',10);
   $pdf->SetXY(14,153); 
   $pdf->Cell(65,10,"Limite para daño físico",1,0,'L');
   $pdf->SetXY(79,153); 
   $pdf->Cell(28,10,$Ldañofisico,1,0,'C');
   $pdf->SetXY(107,153); 
   $pdf->MultiCell(85,5,"Sin deducible para Incendio, Rayo y Explosión. Un mes de renta para el resto de los riesgos.",1,'J',False);


   $pdf->SetXY(14,163); 
   $pdf->Cell(65,5,"Límite para las rentas mientras se ","LTR",0,'L');
   $pdf->SetXY(14,168); 
   $pdf->Cell(65,5,"repara el inmueble por daños cubiertos","LBR",0,'L');
   $pdf->SetXY(79,163); 
   $pdf->Cell(28,10,$LRentas,1,0,'C');
   $pdf->SetXY(107,163); 
   $pdf->Cell(85,10,"Sin deducible",1,0,'L');


   $pdf->SetXY(14,173); 
   $pdf->Cell(65,10,"Límite para daños a terceros",1,0,'L');
   $pdf->SetXY(79,173); 
   $pdf->Cell(28,10,$LDanos3,1,0,'C');
   $pdf->SetXY(107,173); 
   $pdf->MultiCell(85,5,"La que sea mayor de las siguientes cantidades: el 5% de la reclamación ó 50 DSMGVDF.",1,'J');


   $pdf->SetXY(14,183); 
   $pdf->SetFont('Arial','B',10);
   $pdf->MultiCell(178,5,"El prestador pagará por cuenta de El Prestatario los siguientes gastos, cuando se requiera y hasta los límites siguientes: ",1,'J');


   $pdf->SetXY(14,193); 
   $pdf->SetFont('Arial','',10);
   $pdf->Cell(93,10,"Gastos y costas judiciales",1,0,'L');
   $pdf->SetXY(107,193); 
   $pdf->Cell(85,10,"Hasta la recuperación legal del inmueble.",1,0,'C');


   $pdf->SetXY(14,203);
   $pdf->MultiCell(93,5,"Gastos Notariales por la elaboración de poder a nombre de los abogados que litigarán la recuperación del inmueble.",1,'L');
   $pdf->SetXY(107,203); 
   $pdf->Cell(85,15,"1,500.00 pesos.",1,0,'R');

 
   $pdf->SetXY(14,218);
   $pdf->Cell(93,10,"Gastos de lanzamiento o toma de posesión.",1,0,'L');
   $pdf->SetXY(107,218); 
   $pdf->Cell(85,10,$Gtomadeposecion." pesos.",1,0,'R');

   $pdf->SetXY(14,228);
   $pdf->SetFont('Arial','B',10);
   $pdf->MultiCell(178,5,"Las obligaciones de El Prestador descritas en este contrato serán renovados en cada vencimiento a solicitud de El Prestatario mientras que continúe el arrendamiento y hasta que recupere su inmueble. A partir de cada vencimiento de este contrato, el arrendador contará con hasta ".$diasN." días naturales para solicitar la renovación.",1,'J');


}Else{
    
    $pdf->SetXY(14,148); 
   $pdf->SetFont('Arial','B',10);
   $pdf->MultiCell(178,5,"El prestador pagará por cuenta de El Prestatario los siguientes gastos, cuando se requiera y hasta los límites siguientes: ",1,'J');


   $pdf->SetXY(14,158); 
   $pdf->SetFont('Arial','',10);
   $pdf->Cell(93,10,"Gastos y costas judiciales",1,0,'L');
   $pdf->SetXY(107,158); 
   $pdf->Cell(85,10,"Hasta la recuperación legal del inmueble.",1,0,'C');


   $pdf->SetXY(14,168);
   $pdf->MultiCell(93,5,"Gastos Notariales por la elaboración de poder a nombre de los abogados que litigarán la recuperación del inmueble.",1,'L');
   $pdf->SetXY(107,168); 
   $pdf->Cell(85,15,"1,500.00 pesos.",1,0,'R');

 
   $pdf->SetXY(14,183);
   $pdf->Cell(93,10,"Gastos de lanzamiento o toma de posesión.",1,0,'L');
   $pdf->SetXY(107,183); 
   $pdf->Cell(85,10,$Gtomadeposecion." pesos.",1,0,'R');

   $pdf->SetXY(14,193);
   $pdf->SetFont('Arial','B',10);
   $pdf->MultiCell(178,5,"Las obligaciones de El Prestador descritas en este contrato serán renovados en cada vencimiento a solicitud de El Prestatario mientras que continúe el arrendamiento y hasta que recupere su inmueble. A partir de cada vencimiento de este contrato, el arrendador contará con hasta ".$diasN." días naturales para solicitar la renovación.",1,'J');

    
}
///////////////////////Termina cuerpo principal






/////////////////////////////////////////////////////////////////////Segunda Página

$pdf->AddPage();
$pdf->SetAutoPageBreak(False);
$pdf->SetTextColor(162,160,160);
$pdf->SetXY(14,13); 
$pdf->Cell(178,4,$_REQUEST['arrcve'],0,0,'C');
$pdf->SetTextColor(0,0,0);

$pdf->SetXY(14,23); 
$pdf->Cell(178,5,"Condiciones Aplicables a los Servicios Contratados ",1,0,'L',true);
$pdf->SetXY(14,28); 
$pdf->Cell(178,4,"","LR",0,'L');
$pdf->SetFont('Arial','',9);


$pdf->SetXY(14,30); 


if ($Danos==true){
    
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(178,5,$EncabezadoOp1,"LR",0,'L');
    $pdf->SetFont('Arial','',9);
    $pdf->SetXY(14,35); 
    $pdf->MultiCell(178,5,$texto_opcional1,"LR",'J');
    $pdf->SetXY(14,125); 
    $pdf->Cell(178,5,"","LR",0,'L');
    $pdf->SetXY(14,143); 
    $pdf->SetFont('Arial','B',10);
    $pdf->MultiCell(178,5,$encabezado1,"LR",'L');
    $pdf->SetFont('Arial','',9);
    $pdf->SetXY(14,148); 
    $pdf->MultiCell(178,5,$texto_Principal,"LR",'J');
    $pdf->Ln();
    $pdf->SetX(14);
    $pdf->Multicell(178,5,$texto_Principal2,"LR",'J');
    ////////se agrega celda extra para completar margen  renglones atras.
     if($GJudiciales==False ){
        $pdf->SetXY(14,159);
        $pdf->Cell(178,5,"","LR",0,'L');
        
     }Else{
         $pdf->SetXY(14,174);
         $pdf->Cell(178,5,"","LR",0,'L');
         $pdf->SetXY(14,140);
         $pdf->Cell(178,5,"","LR",0,'L');
         $pdf->SetXY(14,163);
         $pdf->Cell(178,5,"","LR",0,'L');
     }
    /////////se agrega final del margen dependiendo del texto
    if($GJudiciales==False ){
        $pdf->SetXY(14,247);
        $pdf->Cell(178,10,"","LRB",0,'L');
    }Else{
       $pdf->SetXY(14,273);
       $pdf->Cell(178,2,"","LRB",0,'L'); 
    }
}Else{
    
    $texto_Principal=$texto_Principal."

El Prestatario deberá rehusarse a hacer convenios modificatorios al contrato de arrendamiento sin haberlo consultado con El Prestador, las modificaciones hechas en esa forma rescindirán el presente contrato de prestación de servicios de pleno derecho sin necesidad de resolución judicial, sin mayor responsabilidad para las partes. Igualmente el incumplimiento de las siguientes obligaciones de El Prestatario tendrán el mismo efecto rescisorio.

Para iniciar una demanda de rescisión o terminación del contrato de arrendamiento, El Prestatario deberá otorgar poderes especiales de pleitos y cobranzas a los abogados que le indique El Prestador, quien cubrirá el costo de este poder hasta la cantidad indicada en este contrato. 

En el momento de iniciar el proceso de demanda y a más tardar 15 días después de que le sea notificado por El Prestador, El Prestatario deberá ceder por escrito a EL Prestador los derechos de recuperación de los gastos y costas judiciales que El Prestador erogue durante el juicio.

En caso de incumplimientos al contrato de arrendamiento, El Prestatario deberá notificar inmediatamente a El Prestador en su domicilio y seguir las instrucciones que se le indiquen. Es muy importante que no haga acuerdos, ni reciba documentos de promesa de pago antes de recibir asesoría de El Prestador.

Si El contrato establece que el inquilino requiere la autorización de El Prestatario de este certificado por escrito para hacer modificaciones al inmueble. En caso de que El Prestatario tenga conocimiento de que se llevan modificaciones al inmueble, deberá informarlo a El Prestador para recibir orientación. En caso de que el inquilino desee hacer algún cambio a la estructura del inmueble, El Prestador asesorará a El Prestatario sobre la conveniencia de hacerlo.";
    
    $pdf->SetXY(14,35); 
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(178,5,$encabezado1,"LR",0,'L');
    $pdf->SetFont('Arial','',9);
    $pdf->SetXY(14,44); 
    $pdf->MultiCell(178,5,$texto_Principal,"LR",'J');
    $pdf->Ln();
    if ($ExtDominio==true){
      $pdf->SetX(14);
      $pdf->SetFont('Arial','B',9);
      $pdf->MultiCell(178,5,$texto_opcional3,"LR",'J');
      $pdf->SetFont('Arial','',9);
      $pdf->SetXY(14,179);
      $pdf->Cell(178,5,"","LR",0,'L');
      $pdf->Ln();
      $pdf->Ln();
      $pdf->Ln();
      $pdf->Ln();
      
     
    }
    $pdf->Ln();
    
    $y_aqui=$pdf->Gety();
    $y_aqui=$y_aqui-10;
    
    
    
    $pdf->SetXY(14,$y_aqui);
    $pdf->Cell(178,5,"","LR",0,'L');
    //if ($ExtDominio==True){
     $pdf->Ln();
    //}
    $pdf->SetX(14);
    $pdf->MultiCell(178,5,$texto_Principal3,"LR",'J');
    
    //Se agregan celdas para rellenar espacios en el margen
    if($ExtDominio==False ){
        $pdf->Ln();
        $pdf->SetX(14);
        $pdf->MultiCell(178,5,"Los gastos originados por el lanzamiento o toma de posesión del inmueble después de que se obtengan las órdenes judiciales correspondientes, serán cubiertos por El Prestador hasta la cantidad indicada en este contrato, en caso de que por las características del inmueble sea necesario cubrir un gasto mayor, El Prestatario acepta cubrir esa diferencia.","LR",'J');
        $pdf->SetXY(14,234);
        $pdf->Cell(178,10,"","LRB",0,'L');
         $pdf->line(14,212,14,224);
         $pdf->line(192,212,192,224);
    }Else{
        $pdf->SetXY(14,230);
        $pdf->Cell(178,5,"","LRB",0,'L');
        
        
        //$pdf->line(15,238,14,242);
        if ($GJudiciales==true){
//            $pdf->SetXY(14,194);
//            $pdf->Cell(178,5,"","LR",0,'L');
//            $pdf->SetXY(14,254);
//            $pdf->Cell(178,10,"","LR",0,'L');
        }
    }
    //Rellenos
    $pdf->SetXY(14,30);
    $pdf->Cell(178,10,"","LR",0,'L');
    $pdf->SetXY(14,40);
    $pdf->Cell(178,10,"","LR",0,'L');
    $pdf->SetXY(14,167);
    $pdf->Cell(178,10,"","LR",0,'L');
    $pdf->SetXY(14,200);
    $pdf->Cell(178,10,"","LR",0,'L');
    $pdf->SetXY(14,220);
    $pdf->Cell(178,10,"","LR",0,'L');
     $pdf->SetXY(14,225);
    $pdf->Cell(178,10,"","LR",0,'L');
    
          
    
}


    
if ($Danos==false and  $GJudiciales==false and $ExtDominio==false){
            $pdf->SetXY(14,219);
            $pdf->Cell(178,5,"","LR",0,'L');
    
}

if ($ExtDominio==true){
    $pdf->Line(14,190,14,200);
    $pdf->Line(192,190,192,200);
}

/////////////////////////Termina segunda pagina





















///////////////////////////////////////////////////////Empieza tercer pagina

$pdf->AddPage();
$pdf->SetAutoPageBreak(False);
$pdf->SetTextColor(162,160,160);
$pdf->SetXY(14,13); 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(178,4,$_REQUEST['arrcve'],0,0,'C');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(14,23); 
$pdf->Cell(178,4,"","LRT",0,'L');
$pdf->SetFont('Arial','',9);



if($Danos==true){
    
   $pdf->SetXY(14,27); 
   $pdf->MultiCell(178,5,"Si El Prestatario sospecha que el inmueble ha sufrido daños o éstos le son reportados por el inquilino, deberá reportar esos hechos a El Prestador para recibir asesoría y para que sean verificados y cuantificados los daños.
       
Si El Prestatario sospecha que el inquilino abandonó el inmueble, no deberá entrar al mismo, ya que estaría cometiendo un delito, debe notificar a El Prestador para recibir orientación y definir la mejor acción a seguir. ","LR",'J');
   
   $pdf->Ln();
   $pdf->SetX(14);
    if($ExtDominio==true){
       $pdf->SetFont('Arial','B',9); 
       $pdf->MultiCell(178,5,$texto_opcional3,"LR",'J');
       $pdf->SetFont('Arial','',9);
       $pdf->Ln();
       $pdf->SetX(14);
    }Else    {
        
        
        $pdf->SetX(14);
    }
    
   $pdf->MultiCell(178,5,"Los gastos originados por el lanzamiento o toma de posesión del inmueble después de que se obtengan las órdenes judiciales correspondientes, serán cubiertos por El Prestador hasta la cantidad indicada en este contrato, en caso de que por las características del inmueble sea necesario cubrir un gasto mayor, El Prestatario acepta cubrir esa diferencia.","LR",'J');
    
   $pdf->Ln(7);
   $pdf->SetX(14);
   $pdf->SetFont('Arial','B',10);
   $pdf->MultiCell(178,5,"Renovación del Contrato","LR",'L');
   $pdf->SetFont('Arial','',9);
   $pdf->Ln(0);
   $pdf->SetX(14);
   $pdf->MultiCell(176,5,"En caso de que el inquilino incumpla con la obligación de renovar las garantías estipuladas en el contrato de arrendamiento  que  garantizan el pago  de sus obligaciones contractuales. El  Prestador  otorgará  la","L",'J');
   
   
    If ($ExtDominio==True){
        $pdf->SetXY(155,114);
    }Else{
        $pdf->SetXY(155,89);
    }
      
   $pdf->SetFont('Arial','B',9);
   $pdf->Cell(39,5," renovacion  de  este","0",0,'C');
   $pdf->Ln(5);
   $pdf->SetX(14);
   $pdf->Cell(85,5,"contrato a la  sóla solicitud de Prestatario, manteniendo","L",0,'L');
   $pdf->SetFont('Arial','',9);
   $pdf->Cell(60,5," los  servicios contratados bajo  este contrato a lo convenido  en","",0,'L');
   $pdf->Ln(5);
   $pdf->SetX(14);
   $pdf->MultiCell(178,5,"el contrato de arrendamiento hasta que el propietario recupere su inmueble. Será requisito para que esta obligación opere que El Prestatario inicie juicio de terminación del contrato de arrendamiento. En este caso El Prestador tendrá derecho al pago de la contraprestación de los servicios renovados de este contrato.","LR",'J');
   $pdf->Ln();
   $pdf->SetX(14);
   $pdf->MultiCell(178,5,"El Prestatario deberá  colaborar en todo  momento con los abogados que lleven el mandato para lograr la terminación del contrato de arrendamiento y recuperar el inmueble en el menor tiempo posible.

En caso de que El Prestatario no cumpliera con las obligaciones señaladas en los párrafos anteriores perderá todo derecho de reclamar los servicios especificados en este contrato y cesará cualquier obligación de pago asumida por El Prestador. ","LR",'J');
   $pdf->Ln(0);
   $pdf->SetX(14);
    
   $pdf->Cell(178,2,"","LRB",0,'L');
   
   If ($ExtDominio==True){
      $pdf->Line(14,31, 14, 171);
      $pdf->Line(192,31, 192, 171);
   }else{
      $pdf->Line(14,31, 14, 146);
      $pdf->Line(192,31, 192, 146);
    
   }
   
   
   
   
   $pdf->SetFont('Arial','B',9);
   If ($ExtDominio==True){
       $pdf->SetXY(14,210);
   }Else{
       $pdf->SetXY(14,200);
   } 
   $pdf->Cell(178,5,"Domicilio de las Partes","",0,'C');
   $pdf->SetFont('Arial','',9);
   $pdf->SetXY(14,218);
   $pdf->MultiCell(88,4,$calle_arrendador,"",'C');
   $pdf->Ln(0);
   $pdf->SetX(14);
   $pdf->MultiCell(88,4,"Colonia  ".$colonia_arrendador,"",'C');
   $pdf->Ln(0);
   $pdf->SetX(14);
   $pdf->MultiCell(88,4,$delegacion_arrendador,"",'C');
   $pdf->Ln(0);
   $pdf->SetX(14);
   $pdf->MultiCell(88,4,$estado_arrendador."  C.P ".$CP_arrendador,"",'C');
//   
//   
//   
   $pdf->SetFont('Arial','',10);
   $pdf->SetXY(109,218);
   $pdf->Cell(85,4,"Av. Insurgentes Sur No. 1605 2do. Nivel L-56","",0,'C');
   $pdf->Ln(4);
   $pdf->SetX(109);
   $pdf->Cell(80,4,"Colonia San José Insurgentes","",0,'C');
   $pdf->Ln(4);
   $pdf->SetX(109);
   $pdf->Cell(80,4,"Benito Juárez","",0,'C');
   $pdf->Ln(4);
   $pdf->SetX(109);
   $pdf->Cell(80,4,"México 03900, D.F.","",0,'C');
   
   $pdf->Ln(10);
   $pdf->SetX(14);
   $pdf->Cell(178,5,"Se firma el presente Contrato en México D.F. el día ".$fechaAct,"",0,'C');
//   
//   
//   
   $pdf->Line(33,262, 93, 262);
   $pdf->Line(123,262, 183, 262);
//   
   $pdf->SetXy(48,263);
   $pdf->SetFont('Arial','B',10);
   $pdf->Cell(20,5,"EL PRESTATARIO                                                                EL PRESTADOR","",0,'l');
   $pdf->SetFont('Arial','',10);
   $pdf->SetXy(15,268);
   $pdf->MultiCell(91,4,$RS_arrendador,0,'C');
   $pdf->SetXy(130,268);
   $pdf->Cell(20,5,"CERTI NET, S. de R.L. de C.V.",0,'l');
//   
}









Elseif($GJudiciales==True){
    $pdf->SetXY(14,27); 
    //If ($ExtDominio==true){
      // $pdf->MultiCell(178,5,"Los gastos originados por el lanzamiento o toma de posesión del inmueble después de que se obtengan las órdenes judiciales correspondientes, serán cubiertos por El Prestador hasta la cantidad indicada en este contrato, en caso de que por las características del inmueble sea necesario cubrir un gasto mayor, El Prestatario acepta cubrir esa diferencia.","LR","J");
       //$pdf->Ln(5);
       
    //}
   
    $pdf->SetX(14);
    $pdf->SetFont('Arial','B',10);
    $pdf->MultiCell(178,5,"Renovación del Contrato","LR",'L');
    $pdf->SetFont('Arial','',9);
    $pdf->Ln(0);
    $pdf->SetX(14);
    $pdf->MultiCell(178,5,"En caso de que el inquilino incumpla con la obligación de renovar las garantías estipuladas  en el contrato de arrendamiento que garantizan  el pago de sus obligaciones contractuales. El Prestador otorgará  la","LR",'J');
    $pdf->SetXY(150,37);
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(24,5," renovacion de este contrato a la sóla","",0,'C');
    $pdf->Ln(5);
    $pdf->SetX(14);
    $pdf->Cell(107,5," solicitud de  Prestatario, manteniendo","L",0,'L');
    //if($ExtDominio==True){
      $pdf->SetXY(73,42);
    //}Else{
      //$pdf->SetXY(73,42);
    //} 
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(120,5," los  servicios  contratados  bajo  este  contrato  a lo convenido  en  el  contrato  de ","",0,'L');
     $pdf->Ln(5);
   $pdf->SetX(14);
   $pdf->MultiCell(178,5,"arrendamiento hasta que el propietario recupere su inmueble. Será requisito para que esta obligación opere que El Prestatario inicie juicio de terminación del contrato de arrendamiento. En este caso El Prestador tendrá derecho al pago de la contraprestación de los servicios renovados de este contrato.","LR",'J');
   $pdf->Ln();
   $pdf->SetX(14);
   $pdf->MultiCell(178,5,"El Prestatario deberá colaborar en todo momento con los abogados que lleven el mandato para lograr la terminación del contrato de arrendamiento y recuperar el inmueble en el menor tiempo posible.

En caso de que El Prestatario no cumpliera con las obligaciones señaladas en los párrafos anteriores perderá todo derecho de reclamar los servicios especificados en este contrato y cesará cualquier obligación de pago asumida por El Prestador. ","LR",'J');
   
   $pdf->Ln(0);
   $pdf->SetX(14);
   $pdf->Cell(178,12,"","LRB",0,'L');   
   $pdf->Line(14,31, 14, 100);
   $pdf->Line(192,31, 192, 100);
   
   
   
   $pdf->SetFont('Arial','B',10);
   if($ExtDominio==True){
     $pdf->SetXY(14,153);    
   }Else{
     $pdf->SetXY(14,148);    
   }
   
   $pdf->Cell(178,5,"Domicilio de las Partes","",0,'C');
   $pdf->SetFont('Arial','',10);
   $pdf->SetXY(14,165);
   $pdf->MultiCell(88,4,$calle_arrendador,"",'C');
   $pdf->Ln(0);
   $pdf->SetX(14);
   $pdf->MultiCell(88,4,"Colonia  ".$colonia_arrendador,"",'C');
   $pdf->Ln(0);
   $pdf->SetX(14);
   $pdf->MultiCell(88,4,$delegacion_arrendador,"",'C');
   $pdf->Ln(0);
   $pdf->SetX(14);
   $pdf->MultiCell(88,4,$estado_arrendador."  C.P ".$CP_arrendador,"",'C');
   
   
   $pdf->SetXY(109,165);
   $pdf->Cell(85,4,"Av. Insurgentes Sur No. 1605 2do. Nivel L-56","",0,'C');
   $pdf->Ln(4);
   $pdf->SetX(109);
   $pdf->Cell(80,4,"Colonia San José Insurgentes","",0,'C');
   $pdf->Ln(4);
   $pdf->SetX(109);
   $pdf->Cell(80,4,"Benito Juárez","",0,'C');
   $pdf->Ln(4);
   $pdf->SetX(109);
   $pdf->Cell(80,4,"México 03900, D.F.","",0,'C');
   
   $pdf->Ln(10);
   $pdf->SetX(14);
   $pdf->Cell(178,5,"Se firma el presente Contrato en México D.F. el día ".$fechaAct,"",0,'C');
   
   
   
   $pdf->Line(33,210, 93, 210);
   $pdf->Line(123,210, 183, 210);
   
   $pdf->SetXy(48,212);
   $pdf->SetFont('Arial','B',10);
   $pdf->Cell(20,5,"EL PRESTATARIO                                                                EL PRESTADOR","",0,'l');
   $pdf->SetXy(14,217);
   $pdf->MultiCell(92,4,$RS_arrendador,0,'C');
   $pdf->SetXy(130,217);
   $pdf->Cell(20,5,"CERTI NET, S. de R.L. de C.V.",0,'l');
   
}





Elseif($ExtDominio==True){
    
    $pdf->SetXY(14,34); 
    $pdf->Ln(5);
    $pdf->SetX(14);
    $pdf->SetFont('Arial','B',10);
    $pdf->MultiCell(178,5,"Renovación del Contrato","LR",'L');
    $pdf->SetFont('Arial','',10);
    $pdf->Ln(0);
    $pdf->SetX(14);
    $pdf->MultiCell(178,5,"En caso de que el inquilino incumpla con la obligación de renovar las garantías estipuladas  en el contrato de arrendamiento que garantizan  el pago de sus obligaciones contractuales. El Prestador otorgará  la","L",'J');
    $pdf->SetXY(168,49);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(24,5," renovacion","R",0,'C');
    $pdf->Ln(5);
    $pdf->SetX(14);
    $pdf->Cell(107,5,"de este contrato a la sóla solicitud de Prestatario, manteniendo","L",0,'L');
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(60,5," los servicios contratados bajo este contrato ","",0,'L');
     $pdf->Ln(5);
   $pdf->SetX(14);
   $pdf->MultiCell(178,5,"a lo convenido en el contrato de arrendamiento hasta que el propietario recupere su inmueble. Será requisito para que esta obligación opere que El Prestatario inicie juicio de terminación del contrato de arrendamiento. En este caso El Prestador tendrá derecho al pago de la contraprestación de los servicios renovados de este contrato.","LR",'J');
   $pdf->Ln();
   $pdf->SetX(14);
   $pdf->MultiCell(178,5,"El Prestatario deberá colaborar en todo momento con los abogados que lleven el mandato para lograr la terminación del contrato de arrendamiento y recuperar el inmueble en el menor tiempo posible.

En caso de que El Prestatario no cumpliera con las obligaciones señaladas en los párrafos anteriores perderá todo derecho de reclamar los servicios especificados en este contrato y cesará cualquier obligación de pago asumida por El Prestador. ","LR",'J');
   
   $pdf->Ln(0);
   $pdf->SetX(14);
   $pdf->Cell(178,8,"","LRB",0,'L');   
   $pdf->Line(14,31, 14, 115);
   $pdf->Line(192,31, 192, 115);
   
   
   
   $pdf->SetFont('Arial','B',10);
   $pdf->SetXY(14,160);
   $pdf->Cell(178,2,"Domicilio de las Partes","",0,'C');
   $pdf->SetFont('Arial','',11);
   $pdf->SetXY(20,180);
   $pdf->MultiCell(80,4,$calle_arrendador,"",'C');
   $pdf->Ln(0);
   $pdf->SetX(20);
   $pdf->MultiCell(80,4,"Colonia  ".$colonia_arrendador,"",'C');
   $pdf->Ln(0);
   $pdf->SetX(20);
   $pdf->MultiCell(80,4,$delegacion_arrendador,"",'C');
   $pdf->Ln(0);
   $pdf->SetX(20);
   $pdf->MultiCell(80,4,$estado_arrendador."  C.P ".$CP_arrendador,"",'C');
   
   
   $pdf->SetXY(111,180);
   $pdf->MultiCell(80,4,"Av. Insurgentes Sur No. 1605 2do. Nivel L-56","",'C');
   $pdf->Ln(0);
   $pdf->SetX(111);
   $pdf->MultiCell(80,4,"Colonia San José Insurgentes","",'C');
   $pdf->Ln(0);
   $pdf->SetX(111);
   $pdf->MultiCell(80,4,"México 03900, D.F.","",'C');
   
   
   
   $pdf->Line(33,225, 93, 225);
   $pdf->Line(123,225, 183, 225);
   
   $pdf->SetXy(48,230);
   $pdf->SetFont('Arial','B',10);
   $pdf->Cell(20,5,"EL PRESTATARIO                                                                EL PRESTADOR","",0,'l');
   $pdf->SetXy(24,235);
   $pdf->MultiCell(82,4,$RS_arrendador,0,'C');
   $pdf->SetXy(130,235);
   $pdf->Cell(20,5,"CERTI NET, S. de R.L. de C.V.",0,'l');
    
    
}
//////////////////////////////////////////////////////////////////////


/////////////////////////7Empieza 3a pagina
////////////////////////////////////////////////////////////////////////

$pdf->Output();


        
       
       
?>