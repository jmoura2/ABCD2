<?php
require_once("combo_inc.php");

function AsociarVinculo($linea){
 	$ix=strpos($linea,"<");
 	if ($ix>0) {
    	echo "<br>".substr($linea,$ix);
 	}
}

function Calendario($campo,$type_de,$iso_tag,$Etq){
global $config_date_format;
	if ($config_date_format=="DD/MM/YY")    // format of the input field
       	$date_format= "%d/%m/%Y";
 	else
       	$date_format= "%m/%d/%Y";
	echo "<!-- calendar attaches to existing form element -->
		<input type=text size=10 name=tag$Etq id=tag$Etq value='";
		if (trim($campo)!="") echo $campo;
		echo "'";
		if ($type_de=="D"){
			if ($iso_tag!="")
				 echo " onChange='Javascript:DateToIso(this.value,document.forma1.tag$iso_tag)'";
		}
		if ($type_de=="ISO") echo " onChange='Javascript:DateToIso(this.value,document.forma1.tag$Etq)'";
	echo "/>
	<a href='javascript:CalendarSetup(\"tag$Etq\",\"$date_format\",\"f_tag$Etq\", \"\",true )'>
		<img src=\"../dataentry/img/calendar.gif\" id=\"f_tag$Etq\" style=\"cursor: pointer;\" title=\"Date selector\"
						align=top /></a>

		";
}

function DibujarHtmlArea($tag,$linea,$numl,$tipoH){
 global $valortag,$fdt,$ver,$arrHttp,$Path,$xEditor,$xUrlEditor,$FCKConfigurationsPath,$FCKEditorPath,$db_path,$msgstr;
	if (trim($numl)=="") $numl=20;
	$numl=$numl*30;
	if ($tipoH!="B"){
		if (!isset($valortag[$tag])) {
	   		$valortag[$tag]="";
	  	}else{
	  		$valortag[$tag]=trim($valortag[$tag]);
	  	}
	}else{
		$fp=file($db_path.$arrHttp["base"]."/html/".trim($valortag[$tag]));
		$valortag[$tag]="";
		foreach ($fp as $value) $valortag[$tag].=trim($value);
	}
	$valortag[$tag]=str_replace("\r","",$valortag[$tag]);
	$valortag[$tag]=str_replace("\n","",$valortag[$tag]);
	echo '
	<textarea cols="100%" id="tag'.$tag. '" name="tag'.$tag.'" rows="'.$numl.'" >';
	echo str_replace("'","`",$valortag[$tag]);
	echo '</textarea>';
	#echo "&nbsp; <a href=javascript:CopiarHtml('tag$tag','A',".$arrHttp["Mfn"].")><img src=../dataentry/img/copy_to_folder.gif height=16 border=0 alt=\"".$msgstr["uploadfile"]."\" title=\"".$msgstr["uploadfile"]."\" align=top>".$msgstr["uploadfile"]."</a>";
?>
<script>
		CKEDITOR.replace('<?php echo "tag$tag"?>', {
			height: 260
		} );
</script>
<!--script type="text/javascript">

// Automatically calculates the editor base path based on the _samples directory.
// This is usefull only for these samples. A real application should use something like this:
// oFCKeditor.BasePath = '/fckeditor/' ;	// '/fckeditor/' is the default value.
//var sBasePath = document.location.pathname.substring(0,document.location.pathname.lastIndexOf('_testcases')) ;
	var sBasePath='<?php echo $FCKEditorPath;?>'
	var oFCKeditor = new FCKeditor( 'tag<?php echo $tag?>','800',<?php echo $numl?> ) ;
	oFCKeditor.BasePath	= sBasePath ;
	oFCKeditor.Config["CustomConfigurationsPath"] = "<?php echo $FCKConfigurationsPath?>"
	oFCKeditor.Config["DefaultLanguage"]		= "<?php echo $_SESSION["lang"]?>" ;

	oFCKeditor.Value	= '<?php echo str_replace("'","`",$valortag[$tag])?>' ;
	//oFCKeditor.Config['EnterMode'] = 'br';
	oFCKeditor.Create() ;
</script -->




<?php
}

function SubCampo($campo,$ksc){

	$ixpos=strpos($campo,'^'.$ksc);
	if($ixpos===false){
		$campo="";
	}else{
		$campo=substr($campo,$ixpos+2);
		$ixpos=strpos($campo,'^');
		if($ixpos===false){
		}else{
			$campo=substr($campo,0,$ixpos);
		}
	}
	return $campo;
}

function DibujarTextRepetible($tag,$fondocelda,$field_t){
global $valortag,$fdt,$ver,$arrHttp,$Path,$db_path,$lang_db,$config_date_format,$msgstr;
	$filas=explode("\n",$valortag[$tag]);
	$t=explode('|',$field_t);
	$cant_fil=$t[8];
	if ($ver="") unset($ver);
	$xtb=explode('/',$t[8]);
	if (count($xtb)>1){
		$fixed_rows=$xtb[0];
		$size=$xtb[1];
	}else{
	    if ($t[7]=='TB'){
	    	$fixed_rows=$xtb[0];
	    	$size=1;
	    }else{
			$fixed_rows="";
			$size=$xtb[0];
		}
	}
 	$tope=count($filas);
	if ($tope==0) $tope=1;
 	if ($fixed_rows>1) {
 		$tope=$fixed_rows;
 		for ($ixr=count($filas);$ixr<=$fixed_rows;$ixr++){
 			$filas[]="";
 		}

 	}

 	echo "<td bgcolor=#FFFFFF valign=top nowrap>".$t[2]."<table id=id_$tag>";
 	$i=-1;
 	$n=100;

 	for ($i=0;$i<$tope;$i++){
 		if ($i>count($filas))
 			$campo ="";
 	    else
 	    	$campo=$filas[$i];
		if (!$ver) {
		   	$Etq=$tag."_".$i;
		   	$maxlength=0;
			if ($t[9]<>""){
				$len_f=explode('/',$t[9]);
				$n=$len_f[0];
				if (isset($len_f[1]))
					$maxlength=$len_f[1];
			}
			echo "<tr><td width=20 valign=top>";
			switch($t[7]){
				case "ISO":
					if ($config_date_format=="DD/MM/YY")    // format of the input field
				        	$date_format= "%d/%m/%Y";
				        else
				        	$date_format= "%m/%d/%Y";
					echo "<!-- calendar attaches to existing form element -->
							<input type=text size=8 name=tag$Etq id=tag$Etq value='";
							if (trim($campo)!="") echo $campo;
							echo "'";
							if ($type_de[7]="ISO") echo " onChange='Javascript:DateToIso(this.value,document.forma1.tag$Etq)'";
					echo "/>
						<a href='javascript:CalendarSetup(\"tag$Etq\",\"$date_format\",\"f_tag$Etq\", \"\",true )'>
 						<img src=\"../dataentry/img/calendar.gif\" id=\"f_tag$Etq\" style=\"cursor: pointer;\" title=\"Date selector\"
     						 /></a>

							";
					break;
				default:

					if ($size>1){
						if ($t[9]==0) $t[9]=100;

						echo "<textarea name=tag".$Etq." rows=$size cols=".$t[9]." class=td";
						if ($maxlength!=0){
							echo " onKeyDown=\"textCounter(document.forma1.tag".$Etq.",document.forma1.rem$Etq,$maxlength)\"
					   			   onKeyUp=\"textCounter(document.forma1.tag".$Etq.",document.forma1.rem$Etq,$maxlength)\"";
   						}
   						echo ">" .$campo."</textarea>";
   						if ($maxlength!=0){
	         				echo "\n<script>max_l['$Etq']=$maxlength</script>\n";
	         				$lengthmax=strlen($campo);
	   						if ($lengthmax==0)
	   							$lengthmax=$maxlength;
	   						else
	   							$lengthmax=$maxlength-$lengthmax;
	   						echo "<br><span align=right><input type=\"text\" name=\"rem$Etq\" size=\"3\" maxlength=\"$maxlength\" value=\"$lengthmax\" class=charCount onfocus=blur()>".$msgstr["avalchars"]."</span>\n";
                    	}
					}else{
						if ($maxlength!=0)
							echo "<a style=\"text-decoration:none\" onMouseover=\"ddrivetip(document.forma1.tag".$Etq.".value,'linen',200 )\"; onMouseout=\"hideddrivetip()\"; onclick=\"hideddrivetip()\">";
						echo "<input type=text name=tag".$Etq." size=$n";
						if ($maxlength!=0) echo " maxlength=$maxlength";
						echo " class=td value=\"$campo\">";
						if ($maxlength!=0) echo "</a>";
					}
					if ($t[10]=="D"){
						$sc_col="";
						$separa=";";
						$base_alfa=$t[11];
						if ($base_alfa=="") $base_alfa=$arrHttp["base"];
						$Formato_alfa=$t[13];
						$prefijo=$t[12];
						echo "<a href='javascript:AbrirIndiceAlfabetico(document.forma1.tag$Etq,\"$prefijo\",\"$sc_col\",\"$separa\",\"$base_alfa\",\"$base_alfa.par\",\"tag$Etq\",\"1\",\"\",\"$Formato_alfa\")'><img src=../dataentry/img/defaultButton_list.png border=0 width=16 valign=top></a>";
						   // echo "</td><td bgcolor=#FFFFFF valign=top nowrap>";
					}
			}

			echo "</td>";

		} else{
	    	echo "<tr><td width=20>".$campo."</td></tr>" ;
		}

 	}


 	echo "</table>";
 	if ($fixed_rows=="" and !$ver )
 		echo "<a href=javascript:addRow('".$t[1]."','','','')>".$msgstr["add"]."</a><br><br>";
}

function ColocarSelect($tag,$subc,$nombrec,$lista_opciones,$campo,$picklist){
global $msgstr,$base;
	$opcion=explode(';',$lista_opciones);
	echo "<select name=".$nombrec." id=$nombrec>\n";
	echo "<option value=''></option>";


	foreach ($opcion as $lin){
		if (trim($lin)!=""){
			$lt=explode('|',$lin);
			if (!isset($lt[0]) or $lt[0]=="") $lt[0]=$lt[1];
			if (!isset($lt[1]) or $lt[1]=="") $lt[1]=$lt[0];
			echo "<option value=\"";
			echo trim($lt[0])."\"";
			if (trim(strtoupper($campo))==trim(strtoupper($lt[0])) && $campo!="")
			 	echo " selected";
			echo ">";
			if (trim($lt[1])=="")
				echo $lt[0];
			else
			    echo trim($lt[1]);
			echo " \n";
		}
	}
	echo "</select>";
    if (isset($_SESSION["permiso"])){
    	if (isset($_SESSION["permiso"]["db_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"]) or  isset($_SESSION["permiso"][$base."_CENTRAL_ALL"])  or  isset($_SESSION["permiso"][$base."_CENTRAL_ACTPICKLIST"])){
			echo " <a href=\"javascript:AgregarPicklist('$picklist','$nombrec','$campo')\"><img src=img/s2.gif alt='".$msgstr["mod_picklist"]."' title='".$msgstr["mod_picklist"]."' border=0></a>";
		}
		echo " <a href=\"javascript:RefrescarPicklist('$picklist','$nombrec','$campo')\"><img src=img/reset.gif alt='".$msgstr["reload_picklist"]."' title='".$msgstr["reload_picklist"]."' border=0></a> &nbsp; ";
	}
}

function DibujarTabla($filas,$tag,$fondocelda,$field_t){
//foreach ($filas as $l) echo "$l<br>";
global $valortag,$fdt,$ver,$arrHttp,$Path,$db_path,$lang_db,$config_date_format,$msgstr;
 	$TablaLeida="";
 	$cipar=$arrHttp["cipar"];
 	$seleccion="";
 	$celda="";
 	$cols=-1;
 	$columnas= Array();
 	$val_def=array();
 	$size= Array ("");
 	$t=explode('|',$field_t);
 	$subc=$t[5];
 	if ($ver=="")  unset($ver);
 	if (substr($subc,0,1)=='-')  $subc="_".substr($subc,1);
 	$cant_cols=strlen($subc);

 	if (isset($ver)){
  		$celda=" cellpadding=0 cellspacing=5 border=0 ";
  		if (count($filas)==0) return;
 	}
 	$seleccion= Array();
 	$ind=Array();
 	echo "<td colspan=5 valign=top>\n<table border=0 id=id_".$t[1];
 	if ($cant_fil==1 or !$ver) {
  		echo " bgcolor=#eeeeee";
 	}else{
 		 echo " bgcolor=#eeeeee";
 	}
 	echo " $celda valign=top>";

	echo "<td colspan=$cant_cols bgcolor=white><strong>".$t[2]."</strong></td><tr>";
 	$indice_alfa="";  // para desplegar el �ndice alfab�tico del campo
  //  echo "<td bgcolor=#eeeeee></td>";

 	foreach($filas as $lin){

    	if (trim($lin)!=""){
	    	$l=explode('|',$lin);
	  		$cols=$cols+1;
	  		$val_def[$l[5]]=$l[15];
	  		$len=$l[9];
	 		$size[$cols]=$len;
	  		$Tabla=$l[10];
	  		$Tab_name=$l[11];

	    	if (trim($Tabla)!=""){
	    		switch ($Tabla){
	   				case "P":
	   					$Tab_name=str_replace("%path_database%",$db_path,$Tab_name);
		   				$xx=explode('/',$Tab_name);
						if (count($xx)>1){
							$fp=file($Tab_name);
						}else{
							if (file_exists($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$Tab_name))
		    					$fp = file($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$Tab_name);
		 					else
								$fp = file($db_path.$arrHttp["base"]."/def/".$lang_db."/".$Tab_name);
						}
	    				foreach ($fp as $tab) {
	   						if (trim($tab)!=""){
	   					// if the table is bases.dat and the databases are purchaseorder or suggestions, include only the databases wich has copies database
	   							if ($Tab_name==$db_path."bases.dat" and ($arrHttp["base"]=="purchaseorder" or $arrHttp["base"]=="suggestions")){     // aqui se filtran las bases de datos para adquisiciones
	   								$tbz=explode('|',$tab);
	   								if (isset($tbz[2]) and trim($tbz[2])=="Y"){
	   								}else{
	   									continue;
	   								}
	   							}
	   							if (!isset($seleccion[$cols]) or $seleccion[$cols]=="")
	   								$seleccion[$cols]=$tab;
	   							else
	     							$seleccion[$cols].=";".$tab;
	     					}
	   					}
	   					break;
	  			}
	  		}
	  		$ind[$cols]=$lin;
	  		if (count($filas)>1){
			if (trim($l[2])!="" and $l[7]!="I") {     //columns title
		    	echo "<td bgcolor=#eeeeee><b>".trim($l[2]);

		    	echo "</b></td>";
			}
			}
		}
	}
 	$filas=explode("\n",$valortag[$tag]);
	$tope=count($filas);
	if ($tope==0) $tope=1;
 	$cant_fil=$t[8];
 	$fixed_rows=$cant_fil;
 	if ($cant_fil==0) $cant_fil=2;
 	if ($fixed_rows>1) {
 		$tope=$fixed_rows;
 		for ($ixr=count($filas);$ixr<=$fixed_rows;$ixr++){
 			$filas[$ixr]="";
 		}

 	}
 	for ($i=0;$i<$tope;$i++){

  		if ($i>=count($filas)){
   			$valorf="";

  		} else {
   			$valorf=trim($filas[$i]);
   		}
   		if (substr($subc,0,1)=='_')
   			$valorf="^_".$valorf;
    	for ($isc=0;$isc<strlen($subc);$isc++){
     		$delim=substr($subc,$isc,1);
     		$pos=strpos(strtoupper($valorf), "^".strtoupper($delim));
     		$campo="";
     		if (is_integer($pos)) {
      			$campo=substr($valorf,$pos+2,strlen($valorf));
      			$pos=strpos($campo, "^");
      			if (!is_integer($pos)) $pos=strlen($campo);
      			$campo=substr($campo,0,$pos);
      			$columnas[$isc]=$campo;
     		} else {
      			if (isset($ver)){
       				$columnas[$isc]="&nbsp;";
      			}else{
      				if (isset($val_def[$delim]))
      					$columnas[$isc]=$val_def[$delim];
      				else
       					$columnas[$isc]="";
      			}
     		}
    	}
  		echo "<tr>";
  	//	$iseq=$i+1;
  		for ($j=0;$j<=$cols;$j++){
   			$n=$size[$j];
   			if ($n==0) $n=100;
  	 		$campo="";
   			if (count($columnas)>0) {
    			if ($i<count($filas)){
     				$campo=$columnas[$j];
    			} else {
     				if ($ver){
      					$campo=" &nbsp; ";
     				}else {
      					$campo="";
     				}
    			}
   			}


     			$linea=$ind[$j];
     			$type_de=explode('|',$linea);
				$Etq=$tag."_".$i."_".substr($subc,$j,1);
				echo "<td bgcolor=#FFFFFF valign=top nowrap>";
                if ($j==0){
                	if (isset($Etq) and !isset($ver)) echo "<a href=javascript:RowClean('$Etq','$subc')>".$msgstr["erase"]."</a> ";
				//echo substr($subc,$j,1);
				}
				if ($type_de[7]!="COMBO" and $type_de[7]!="COMBORO"){
					if ($type_de[10]=="D" or $type_de[12]!=""){
						if ($j==0){
							$sc_col=$subc;
						}else{
							$sc_col=substr($subc,$j,1);
						}
						$separa=";";
						$base_alfa=$type_de[11];
						if ($base_alfa=="") $base_alfa=$arrHttp["base"];
						$Formato_alfa=$type_de[13];
						if (trim($type_de[14])!="") $Formato_alfa.=",`$$$`,".$type_de[14];
						$prefijo=$type_de[12];
					    if (!isset($ver)) echo "<a href='javascript:AbrirIndiceAlfabetico(document.forma1.tag$Etq,\"$prefijo\",\"$sc_col\",\"$separa\",\"$base_alfa\",\"$base_alfa.par\",\"tag$Etq\",\"1\",\"\",\"$Formato_alfa\")'><img src=../dataentry/img/defaultButton_list.png border=0 height=15 style=\"vertical-align:middle\"></a>";
					   // echo "</td><td bgcolor=#FFFFFF valign=top nowrap>";
					}
				}
//				echo ($campo);
				$iso_tag="";
				switch($type_de[7]){
					case "I":
						if (isset($ver)){
							echo $campo;
						}else{
							echo "<input type=hidden name=tag$Etq id=tag$Etq value=\"".$campo."\">\n";
						}
						break;
					case "S":
	   					$nombrec="tag".$tag."_".$i."_".substr($subc,$j,1);
			   			if (isset($seleccion[$j]) && ($seleccion[$j]!="")){
			   				if (!isset($ver)){
								ColocarSelect($tag,substr($subc,$j,1),$nombrec,$seleccion[$j],$campo,$type_de[11]);
			    			}else{
			    				echo $campo;
			    			}
						}
						break;
					case "D":    //fecha, se presenta el calendario
						if (isset($ind[$j+1])){
							$next_field=explode('|',$ind[$j+1]);  //IF THE NEXT FIELD IS AN ISO FIELD CALL THE CONVERSION PROCEDURE
       						if (trim($next_field[7])=="ISO"){
       							$iso_tag=$tag."_".$i."_".substr($subc,$j+1,1);
       						}else{
       							$iso_tag="";
       						}
       					}
					case "ISO":
						if (isset($ver))
							echo $campo;
						else
							Calendario($campo,$type_de[7],$iso_tag,$Etq);
						break;
					case "C":
						if (isset($ver))
							echo $campo;
						else
							DibujarCheck($filas,$fondocelda,$valor,$tag,$opciones,$tope,$tipo,$subc);
                        break;
					case " ":
					case "":

					case "X":
						$maxlength=0;
						if ($type_de[9]<>""){

							$len_f=explode('/',$type_de[9]);
							$n=$len_f[0];
							if (isset($len_f[1]))
								$maxlength=$len_f[1];
						}
						if ($type_de[8]>1){
                            if (!isset($ver)){
								echo "<textarea name=tag".$Etq." rows=".$type_de[8]." cols=".$n." class=td";
								if ($maxlength>0){
	   								echo " onKeyDown=\"textCounter(document.forma1.tag".$Etq.",document.forma1.rem$Etq,$maxlength)\"
					   					onKeyUp=\"textCounter(document.forma1.tag".$Etq.",document.forma1.rem$Etq,$maxlength)\"";
								}
	   							echo " id=tag".$Etq.">" .$campo."</textarea>";
	                            if ($i==0) echo "\n<script>max_l['$Etq']=$maxlength</script>\n";
	   							if ($maxlength>0){
	   								$lengthmax=strlen($campo);
	   								if ($lengthmax==0)
	   									$lengthmax=$maxlength;
	   								else
	   									$lengthmax=$maxlength-$lengthmax;
	   								echo "<br><input type=\"text\" name=\"rem$Etq\" size=\"3\" maxlength=\"$maxlength\" value=\"$lengthmax\" class=charCount onfocus=blur()>".$msgstr["avalchars"]."\n";
	   							}
	   						}else{
	   							echo nl2br($campo);
	   						}
						}else{
							if (!isset($ver)){
								if ($maxlength!=0)
									echo "<a style=\"text-decoration:none\"; onMouseover=\"ddrivetip(document.forma1.tag".$Etq.".value,'linen',200 )\"; onMouseout=\"hideddrivetip()\";>";
								echo "<input type=text name=tag".$Etq."  id=tag".$Etq." size=$n";
								if ($maxlength!=0) {
									echo " maxlength=$maxlength";
									echo "  onBlur=\"hideddrivetip();document.forma1.tag".$Etq.".size=$n\"
									  onFocus=\"hideddrivetip();document.forma1.tag".$Etq.".size=$maxlength\";";
								}
								echo " class=td value=\"$campo\">";
								if ($maxlength!=0) echo "</a>";
							}else{
								echo nl2br($campo);
							}
						}

    					break;
    				case "XF":
    					if (isset($ver))
    						echo $campo;
    					else
    						echo "<input type=text name=tag".$Etq." id=tag".$Etq." size=$n maxlength=$n class=td value=\"$campo\">";
    					break;
    				case "U":
    					if (isset($ver)){
    						echo $campo;
    					}else{
	     					echo "<input type=text name=tag".$Etq." id=tag".$Etq." size=$n class=td value=\"$campo\">";
    	 					echo "<a href=javascript:EnviarArchivo('tag$Etq')><img src=../dataentry/img/upload.gif border=0 alt=\"".$msgstr["uploadfile"]."\" title=\"".$msgstr["uploadfile"]."\"></a> ";
     						echo "<a href=dirs_explorer.php?Opcion=seleccionar&base=".$arrHttp["base"]."&tag=tag$Etq target=_blank><img src=../dataentry/img/setsearch.gif border=0 alt=\"".$msgstr["selfile"]."\" title=\"".$msgstr["selfile"]."\"></a>";
     					}
     					break;
     				case "K":
     					if (isset($ver)){
     						echo $campo;
     					}else{
     						echo "<input type=text name=tag".$Etq." id=tag".$Etq." size=$n class=td value=\"$campo\">";
     						echo "<a href=javascript:EnviarArchivo('tag$Etq')><img src=../dataentry/img/upload.gif border=0 alt=\"Subir archivo al servidor\"></a>";
   							echo "<a href=javascript:EditarArchivo('tag$Etq')><img src=../dataentry/img/edit.gif border=0 alt=\"Editar archivo existente\"></a>";
  						}
  						break;
 					case "AI":
 						if (isset($ver)){
 							echo $campo;
 						}else{
 							echo "<input type=hidden name=autoincrement value=$Etq>";
	 						echo "<input type=hidden name=tag".$Etq." size=$n class=td value=\"$campo\">$campo";
 						}
 						break;
 					case "RO":
 						if (isset($ver)){
 							echo $campo;
 						}else{
 							echo $campo;
 							echo "<input type=hidden name=tag".$Etq." id=tag".$Etq." size=$n class=td value=\"$campo\" onfocus=blur()>";

 						}
 						break;
 					case "DC":
 						if (isset($ver)){
 							echo $campo;
 						}else{
	 						Calendario($campo,$type_de[7],$iso_tag,$Etq);
	 						if ($campo==""){
	 							echo "<a href=javascript:AgregarFecha('tag$Etq')><img src=img/s2.gif border=0 alt='".$msgstr["add"]."' title='".$msgstr["add"]."'></a>";
	 						}
                        }
 						break;
 					case "OC":
 						if (isset($ver)){
 							echo $campo;
 						}else{
	 						echo "<input type=text name=tag".$Etq." name=tag".$Etq." size=10 class=td value=\"$campo\" onfocus=blur()>";
	 						if ($campo=="")
	 							echo "<a href=javascript:AgregarOperador('tag$Etq')><img src=img/s2.gif border=0 alt='".$msgstr["add"]."' title='".$msgstr["add"]."'></a>";
	 						break;
                       }

	  			}

				echo "\n";


  		}

 	}
 	echo "</TD></tr></table>";
 	if ($t[4]==1 and $fixed_rows=="" and !isset($ver)){
 		$vd="";
 		if (count($val_def)>0){
 			foreach ($val_def as $key=>$value){
 				$vd.=$key."|".$value."$$$";
 			}
 		}
 		echo "<a href=javascript:addRow('".$t[1]."','$subc','add','$vd')>".$msgstr["add"]."</a> | ";

 		echo "<a href=javascript:addRow('".$t[1]."','$subc','duplicate','')>".$msgstr["duplicate_last"]."</a>";
 		echo " | <a href=javascript:Organizar('".$t[1]."','$subc')>Organizar</a>";
 	}
 	echo "<br><br></td>";
 	echo "\n</td></td>";
 	//if (substr($linea,37,1)!=1) echo "<td bgcolor=$fondocelda> </td>";
}

function DecodificaSubCampos($campo,$numsubc,$subc,$delimsc){
	if (trim($delimsc)=="") return $salida;
	$valores=explode("\n",$campo);
	$salida="";
	foreach ($valores as $lin){
		 for ($isc=0;$isc<strlen($subc);$isc++){
		   	$delim=substr($subc,$isc,1);
		   	$pos=strpos($lin, "^".$delim);
		   	if (is_integer($pos)) {
		   		if ($isc==0)
		   			$delim="";
				else
		   			$delim=substr($delimsc,$isc,1)." ";
		    	$lin=substr($lin,0,$pos).$delim.substr($lin,$pos+2);
		  	}

		 }
         $salida=$salida."\n".$lin;
	}
	return $salida;
}


function DibujarCheck($filas,$fondocelda,$valor,$tag,$opciones,$tope,$tipo,$subc){
global $ver,$base,$arrHttp,$Path,$db_path,$lang_db;

echo "<td bgcolor=#FFFFFF class=textbody03 align=left valign=top>";
if (!$ver){
	if ($tope>1) {
    	echo "<table>\n";
	}
//	echo $db_path.$arrHttp["base"]."/".$opciones;
	if ($opciones==1){
		$fp=array(1);
	}else{
		if (strpos($opciones,'%path_database%')===false){
			if (file_exists($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$opciones))
	    		$fp=file($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$opciones);
	    	else
	    		$fp=file($db_path.$arrHttp["base"]."/def/".$lang_db."/".$opciones);
		}else{
			$fp=file(str_replace('%path_database%',$db_path,$opciones));

		}
	}
    $i=0;
    $j=0;
    $ixo=-1;
    $ix=0;
    $val=explode("\n",$valor);
    foreach ($fp as $linea){
    	$linea=trim($linea);
   		if ($linea!=""){
			if ($tope>1) {
			   	echo "<td class=td nowrap>";
			}
         //   echo ($subc);
			$opc=explode('|',$linea);

			if ($opc[0]=="") $opc[0]=$opc[1];
			if ($opc[1]=="") $opc[1]=$opc[0];
			if (!isset($opc[1]))$opc[1]=$opc[0];
			$opcVal=$opc[0];
			if (trim($subc)!=""){
				$opcVal="^".substr($subc,0,1).$opc[0]."^".substr($subc,1,1).$opc[1];
			}
			$i=$ix+1;

      		if ($tipo=="R") echo "<input type=radio name=tag$tag id=tag$tag value=\"".$opcVal."\"";
      		if ($tipo=="C" or $tipo=="RP") echo "<input type=checkbox name=tag$tag id=tag$tag value=\"".$opcVal."\"";
      		foreach ($val as $check) {

      			if ($subc!=""){
      				$cc=explode('^',$check);
      				if (isset($cc[1]))$check=substr($cc[1],1);
      			}
      			if (trim($check)==trim($opc[0])) echo " checked";
      		}
      		if ($opciones==1)
      			echo  ">";
      		else
      			echo ">&nbsp;".$opc[1]." &nbsp; &nbsp;\n";
			if ($tope>1) {
				echo "</td>";
			}
			$ixo=$ixo+1;
     		if ($ixo>=$tope-1 and $tope>1) {
        		$ixo=-1;
      			echo "<tr>";
     		}else{
				if ($tope==0 or $tope==1) echo "<br>";
			}
    	}
  	}
	if ($tope>1) {
	    echo "</table>";
	}
 }else {
  	$filas=explode("\n",$valor);
  	$ix=0;
//  	echo "<td>";
  	foreach ($filas as $lin){
   		$ix=$ix+1;
   		$lin=trim($lin);
   		echo "$lin";
   		if ($ix<count($filas)) echo "<br>";
  	}
 }

 echo "\n</td></xTABLE>\n";
}


function DibujarSelect($linea,$fondocelda,$valor,$tag,$ksc,$opciones,$rep,$subc){
global $ver,$base,$arrHttp,$Path,$Tabla_sel,$db_path,$lang_db,$msgstr;
	$t=explode('|',$linea);
 	$tipo=rtrim($t[7]);
 	$rep=$t[4];
 	$subc=rtrim($t[5]);
 	$ksc=strlen($subc);
 	$delimsc=rtrim($t[6]);
	echo "<td bgcolor=#FFFFFF>";
	$TipoS="";
	if ($rep==1) $TipoS=" multiple";
	if (!$ver){
		$file_options="";
		if (strpos($opciones,'%path_database%')===false){
			if (file_exists($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$opciones)){
				$file_options=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$opciones;
	    		$fp=file($file_options);
	    	}else{
	    		$file_options=$db_path.$arrHttp["base"]."/def/".$lang_db."/".$opciones;
	    		$fp=file($file_options);
	    	}
		}else{
			$file_options=str_replace('%path_database%',$db_path,$opciones);
			//echo $file_options;
			$fp=file($file_options);
		}
	   	$i=0;
		$lensel=count($fp);
		if ($lensel>10)
			$lensel=0;
		else
			$lensel=$lensel+1;

		$val=explode("\n",$valor);
		foreach ($fp as $linea){
			if ($opciones=="%path_database%bases.dat" and ($arrHttp["base"]=="purchaseorder" or $arrHttp["base"]=="suggestions")){     // aqui se filtran las bases de datos para adquisiciones
				$tbz=explode('|',$linea);

				if (isset($tbz[2]) and trim($tbz[2])=="Y"){
				}else{
					continue;
				}
			}
	   		$linea=trim($linea);
	   		$pp=explode('|',$linea);

			if ($linea!=""){
	            if ($pp[0]!="")
	            	$key1=$pp[0];
				else
					$key1=$pp[1];
				if ($pp[1]=="")
					$key2=$key1;
				else
					$key2=$pp[1];
				$opc[$key2]=$key1;
			}
		}
		echo "<select name=tag$tag $TipoS id=tag$tag";
		if ($lensel<>0 and $TipoS==" multiple")
			echo " size=$lensel";
		echo ">\n";
		echo "<option value=\"\">";
		$check="";
		foreach ($opc as $key1=>$key2){
			$opcVal=$key2;
			if (trim($subc)!=""){
				$opcVal="^".substr($subc,0,1).$key2."^".substr($subc,1,1).$key1;
			}
	  			echo "<option value=\"".$opcVal."\"";
	  			foreach ($val as $check){
	  				if (trim($check)!=""){
	   				if ($subc!=""){
	      				$cc=explode('^',$check);
	      				$check=substr($cc[1],1);
	      			}
	      			if (trim($check)==trim($key2) and trim($key2)!="") echo " selected";
	      		}
	  			}
	  			echo ">".$key1." &nbsp; &nbsp;\n";

	   	}
		echo "</select>";
		if ($file_options!="") {
			$opciones=urlencode ( $opciones);
			if (isset($_SESSION["permiso"])){
				if (isset($_SESSION["permiso"]["db_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"]) or  isset($_SESSION["permiso"][$base."_CENTRAL_ALL"])  or  isset($_SESSION["permiso"][$base."_CENTRAL_ACTPICKLIST"])){
	        		echo " <a href=\"javascript:AgregarPicklist('$opciones','tag$tag','$check')\"><img src=../dataentry/img/s2.gif alt='".$msgstr["mod_picklist"]."' title='".$msgstr["mod_picklist"]."' border=0></a>";
	        	}
				echo " <a href=\"javascript:RefrescarPicklist('$opciones','tag$tag','$check')\"><img src=../dataentry/img/reset.gif alt='".$msgstr["reload_picklist"]."' title='".$msgstr["reload_picklist"]."' border=0></a> &nbsp; ";
			}
		}

	}else {
	  	$filas=explode("\n",$valor);
	  	$ix=0;
	  	foreach ($filas as $lin){
	   		$ix=$ix+1;
	   		$lin=trim($lin);
	   		echo "$lin";
	   		if ($ix<count($filas)) echo "<br>";
  	}
}

echo "\n</td></tr>\n";
}


function TextBox($linea,$fondocelda,$titulo,$ver,$len,$tag,$ksc,$rep,$delimrep,$ayuda){
global $ixicampo,$valortag,$arrHttp,$Path,$Marc,$db_path,$lang_db,$msgstr,$MD5,$SECURE_PASSWORD_LEVEL,$SECURE_PASSWORD_LENGTH;
	 $maxlength=0;
	 $t=explode('|',$linea);
	 //ESTO SE PONE PARA LOS CAMBIOS QUE SE HICIERON EN LA FDT EN CUANTO AL TIPO DE CAMPO Y EL TIPO DE INGRESO
	 switch ($t[0]){
		case "OD":
				$t[0]="F" ;
				$t[7]="OD";
		  		break;
		  	case "OC":
		       $t[0]="F";
		       $t[7]="OC";
		  		break;
		    case "ISO":
		       $t[0]="F";
		       $t[7]="ISO";
		  		break;
		    case "DC":
		    	$t[7]="DC";
				break;
	}

	 $tipo=rtrim($t[7]);
	 if ($t[0]=="AI") {
	 	$tipo="AI";
	 	if ($arrHttp["Mfn"]=="New")
	 		$valortag[$tag]="";
	 }
	 $rep=$t[4];
	 $subc=rtrim($t[5]);
	 $ksc=strlen($subc);
	 $delimsc=rtrim($t[6]);
	 $mandatory=trim($t[19]);
	 $numl=$t[8];
	 $cols=$t[9];
	 if ($cols==0) $cols=100;
	 $len=$cols;
	 $tag=$t[1];
	 $pref=$t[12];
	 $help="";
	 if (isset($t[16])) $help=$t[16];
	// $upload=substr($linea,53,1);
	 if ($tipo!="I"){
	 	echo "<td width=130 class=rotuloIng bgcolor=#FFFFFF valign=top>";
	 	$titulo=trim($t[2]);
	 	echo $titulo;
	 	echo "</td>";
	 	echo "<td  bgcolor=#FFFFFF class=textbody03 align=left>";
	 }
	 if ($rep==1 and $numl==0) $numl=1;
	 if ($numl==0) $numl=1;
	 $valortag[$tag]=rtrim($valortag[$tag]);
	 $dummy=explode("\n", $valortag[$tag]);
	 $occurs=count($dummy);
	 if ($ver) {
	  	foreach ($dummy as $lin){
	   		if ($ksc>0 and trim($delimsc)!="") $lin=DecodificaSubCampos($lin,$ksc,$subc,$delimsc);
	   		if ($tipo!="I")echo $lin."<br>";
	  	}
	 } else {

	  		$campo=rtrim($valortag[$tag]);
	  		if ($ksc>0 && $campo!=""  and trim($delimsc)!="") $campo=DecodificaSubCampos($campo,$ksc,$subc,$delimsc);
	  		if ($numl<count($dummy)) $numl=count($dummy);
	  		if ($numl>30) {
	      		$numl=30;
	  		}


			$arrow="";
			if ($rep=="1" ) {
				//$arrow="ONKEYDOWN=\"return checkKey(this, event,document.forma1.tag$tag,$ixicampo)\"";
			}
			if ($tipo=="XF") $len=$cols." maxlength=$cols";

	  		if (($numl>1 or $rep=="1") and $tipo!="AI"){
	  		  	//if ($numl<=1 ) $numl=2;

	  			if ($len==0) $len="100%";
	   			if ($tipo=="RO" or $tipo=="SRO" or $tipo=="MRO")
					$it="text onfocus=blur()";
				else
					$it="";
				$maxlength=0;
				if ($t[9]==0) $t[9]=100;
				if ($t[9]!=""){
			    	$lenf=explode('/',$t[9]);
			    	$len=$lenf[0];
			    	if (isset($lenf[1]))
			    		$maxlength=$lenf[1];
			    }

	   			echo "<textarea rows=$numl cols=$len  name=tag$tag id=tag$tag $arrow $it";
	   			if ($maxlength>0){
	   				echo " onKeyDown=\"textCounter(document.forma$ixforms.tag_".$tag.",document.forma$ixforms.rem$tag,$maxlength)\"
					   	onKeyUp=\"textCounter(document.forma1.tag".$tag.",document.forma1.rem$tag,$maxlength)\"";
				}
	   			echo ' onKeyUp="CheckInventory()" >' .$campo."</textarea>";
	   			if ($maxlength>0)
	   				echo "<br><input readonly type=\"text\" name=\"rem$tag\" size=\"3\" maxlength=\"$maxlength\" value=\"$maxlength\" class=charCount>".$msgstr["avalchars"]."\n";
	  		}else{
	   			if ($len==0) $len="100";
				switch ($tipo){
					case "P":
					case "PR":
						$it="password ";
						if ((isset($SECURE_PASSWORD_LEVEL) and $SECURE_PASSWORD_LEVEL!="") or
						    (isset($SECURE_PASSWORD_LENGTH) and $SECURE_PASSWORD_LENGTH!=""))
						    	$it.="onblur=\"pwd_Validation('tag$tag')\" ";
						$len=20;
						if ($MD5==1) $campo="";
						break;
					case "AI":
						echo "<input type=hidden name=autoincrement value=$tag>";
						$it="text onfocus=blur()";
						break;
					case "RO":
                    case "SRO":

						$it="text onfocus=blur()";
						break;
					case "I":
						$it=" hidden";
						break;
					default:
						$maxlength=0;
					    if ($t[9]!=""){
					    	$lenf=explode('/',$t[9]);
					    	$len=$lenf[0];
					    	if (isset($lenf[1]))
					    		$maxlength=$lenf[1];
					    }
						$it="text";
						break;

				}
				if ($maxlength!=0)
						echo "<a style=\"text-decoration:none\" onMouseover=\"ddrivetip(document.forma1.tag".$tag.".value,'linen',300 )\"; onMouseout=\"hideddrivetip()\"; onclick=\"hideddrivetip()\">";
	   			echo "<input type=$it name=tag$tag id=tag$tag size=$len ";
	   			if ($maxlength>0){
	   				echo " maxlength=$maxlength ";
	   			}
	   			echo" value=\"$campo\" $arrow>";

	   			if ($maxlength!=0)
	   				echo "</a>";
	   			if ($tipo=="AI") {
	   				if (isset($_SESSION["permiso"]["CENTRAL_RESETLCN"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"])  or isset($_SESSION["permiso"][$arrHttp["base"]."_CENTRAL_ALL"]) or isset($_SESSION["permiso"][$arrHttp["base"]."_CENTRAL_RESETLCN"]) or isset($_SESSION["permiso"]["ACQ_ALL"]) or isset($_SESSION["permiso"]["ACQ_RESETCN"])){
	   					echo " <a href=javascript:ChangeSeq($tag,\"$pref\")>".$msgstr["assign"]."</a>
	   					&nbsp ";
	   					echo "<a href=../documentacion/ayuda.php?help=".$_SESSION["lang"]."/autoincrement.html target=_blank>".$msgstr["help"]."</a>&nbsp &nbsp;";
	   					if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"])){
							echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/autoincrement.html target=_blank>".$msgstr["edhlp"]."</a>";
						}
	   				}
	   			}
	  		}
			if ($tipo=="U" ) {
				echo "<a href=javascript:EnviarArchivo('tag$tag')><img src=../dataentry/img/upload.gif border=0 alt=\"".$msgstr["uploadfile"]."\" title=\"".$msgstr["uploadfile"]."\"></a> ";
     			echo "<a href=dirs_explorer.php?Opcion=seleccionar&base=".$arrHttp["base"]."&tag=tag$tag target=_blank><img src=../dataentry/img/setsearch.gif border=0 alt=\"".$msgstr["selfile"]."\" title=\"".$msgstr["selfile"]."\"></a>";
	   		}
	   		if ($tipo=="P" or $tipo=="PR"){
	   		    echo "\n<script>tag_password='tag$tag'
	   		    mandatory_password='".$mandatory. "'
	   		    </script>\n";
	   		    echo "<a href=javascript:DisplayPassword('tag$tag')>".$msgstr["ver"]."</a>";
	   			if ((isset($SECURE_PASSWORD_LEVEL) and $SECURE_PASSWORD_LEVEL!="") or (isset($SECURE_PASSWORD_LENGTH) and $SECURE_PASSWORD_LENGTH!="")){
	   				echo "<br><font color=darkred>";
	   				if (isset($SECURE_PASSWORD_LENGTH) and $SECURE_PASSWORD_LENGTH!="")
	   					echo $msgstr["pass_format_1"] ." ".$SECURE_PASSWORD_LENGTH." ".$msgstr["characters"].". ";
	   				if (isset($SECURE_PASSWORD_LEVEL) and $SECURE_PASSWORD_LEVEL!="")
	   					echo $msgstr["pass_format_".$SECURE_PASSWORD_LEVEL];
	   				echo  ' &nbsp;<span id="spnPwd" class="pwd_Strength" ></span><br />';
	   			}
	   			echo "</td><tr><td colspan=2></td><td>Confirm password</td><td><input type=password size=$len name=confirm id=confirmpwd  value=\"$campo\"";
	   			if ((isset($SECURE_PASSWORD_LEVEL) and $SECURE_PASSWORD_LEVEL!="")  or (isset($SECURE_PASSWORD_LENGTH) and $SECURE_PASSWORD_LENGTH!="") ) echo " onfocus=VerificarPassword('tag$tag')";
	   			echo ">";
	   			echo "<a href=javascript:DisplayPassword('confirmpwd')>".$msgstr["ver"]."</a>";
	   		}

	 }
	 if ($tipo=="SRO" or $tipo=="MRO" ){
	   				echo "<a href=\"javascript:Limpiar(document.forma1.tag$tag)\">borrar</a>";
	   			}
	 if ($tipo!="I") echo "<br><br></td></tr>\n";

}

Function PrepararFormato() {
	global $msgstr,$vars,$ver,$fondocelda,$valortag,$ixicampo,$base,$cipar,$arrHttp,$FdtHtml,$Html_ingreso,$tagisis,$db_path,$lang_db,$default_values;
    global $config_date_format,$base_fdt,$is_marc,$reintentar,$tag_tipol,$tag_nivel_r;
    //Se lee el archivo typeofrecords.tab para determinar los campos donde est� el tipo de literatura el nivel de registro para la asignaci�n del campo 08
    	$tag_tipol="";
    	$tag_nivelr="";
    	if (file_exists($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/typeofrecord.tab")){
    		$f=fopen($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/typeofrecord.tab",'r');
    		$tor=fgets($f);
    		$tor=explode(' ',trim($tor));
    		if (isset($tor[0])) $tag_tipol=$tor[0];
    		if (isset($tor[1])) $tag_nivelr=$tor[1];
    	}
//SE LEE EL ARCHIVO DE AYUDAS EN L�NEA
	if (file_exists($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/help.tab")){

		$hlp=file($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/help.tab");
		foreach ($hlp as $value) {
			if (trim($value)!=""){
				$vhlp=explode('=',$value,2);
				$hlp_tip[$vhlp[0]]=$vhlp[1];
			}
		}
	}
    if ($ver=="S") $ver=true;
	$cipar=$arrHttp["cipar"];
	$ixTab=-1;
	$ixicampo=0;

	$first_time="Y";
	$is_marc="";
	$cargar_texto="";
	$secciones=array();
	$numero_secciones=0;
	for ($ivars=0;$ivars<count($vars);$ivars++){
 		$linea=$vars[$ivars];
		$t=explode('|',$linea);
		if ($t[0]=="L"  or $t[0]=="H")
			$numero_secciones=$numero_secciones+1;
	}
	$obligatorio="N";
	echo "
			<div id=\"loading\" style=opacity:0.95>
				<p><p>
				<table align=center>
					<tr>
						<TD width=400>
							<SELECT NAME=\"reorg\" id=\"reorg\" MULTIPLE SIZE=20 style=\"width:600px\">
							</SELECT>
						</TD>
						<TD ALIGN=\"left\" VALIGN=\"MIDDLE\" width=50>
							<a href=# onClick=\"moveOptionUp(document.forma1.reorg)\" class=boton>".$msgstr["r_subir"]."</a>
							<BR><BR>
							<a href=\"javascript:moveOptionDown(document.forma1.reorg)\" class=boton>".$msgstr["r_bajar"]."</a>
						</TD>
					</tr>
					<tr>
						<td>
							<a href=\"javascript:OrganizarSalir('aceptar')\">".$msgstr["aceptar"]."</a>
							&nbsp; | &nbsp;
							<a href=\"javascript:OrganizarSalir('cancelar')\">".$msgstr["cancelar"]."</a>
						</td>
						<td></td>
					</tr>
				</table>
			</div>";
	for ($ivars=0;$ivars<count($vars);$ivars++){
		$help_url="";
 		$linea=$vars[$ivars];
		$t=explode('|',$linea);
		$titulo=$t[2];
		$len=$t[9];
		$rep=$t[4];
		$delrep="";
		if (!isset($t[13])) $t[13]="";
		$fe=urlencode($t[13]);
		if (isset($t[17]))
			if (trim($t[17])!="")$help_url=$t[17]   ;
		$tipo_e="";
		$entryType="";
		if (!$ver or $ver and isset($valortag[$t[1]]) or ($t[0]=="H" or $t[0]=="L")){
		echo "</center>";
		if (($t[0]=="H" or $t[0]=="L" or $ivars==0)){
			if ($first_time=="Y"){
				$first_time="N";
				if ($ivars==0) {
					$display="";
				}else{
					$display="display:none";
				}
			}else {
				$display="display:none";
				if (isset($titulo_ant) and $titulo_ant!="*" and $numero_secciones>0){
					echo "\n<a href=\"javascript:switchMenu('myvar_$ixant');\" style=\"text-decoration:none \">";
					if (substr($titulo_ant,0,1)!="<"){
						echo "<img src=../dataentry/img/minus.gif border=0 style=\"vertical-align:middle\"> &nbsp;<strong>".$msgstr["cerrar"]."</strong></a> $titulo_ant";
					}else{
						echo $msgstr["cerrar"];
					}
					echo "<p></div></div>\n";
				}else{
				    echo "\n</div>\n";
				}
			}
			if ($t[0]=="L") $display="";
			if ($t[0]=="H" or $t[0]=="L"  ){
				if ($ivars>0){
					if ($t[0]=="H"){
						$secciones["myvar_$ivars"]="myvar_$ivars";
						$titulo_ant=$titulo;
					}else{
						$titulo_ant="*";
					}
				}
				echo "\n<div id=\"wrapper\">";
				if ($t[0]=="H" and $numero_secciones>0)
					echo "<a onclick=\"switchMenu('myvar_$ivars');\" style=\"text-decoration:none \">";
				else
					echo "<a onclick=#>";
				if (substr($titulo,0,1)!="<" and $numero_secciones>0)
					echo "<img src=../dataentry/img/plus.gif border=0 style=\"vertical-align:middle\" > &nbsp;<strong>$titulo</strong>";
				else
					echo $titulo;
				echo "</a>";
				if (trim($t[17])!=""){
					echo $hlp_tip[$t[17]];
				}
				echo "<div id=\"myvar_$ivars\" style=\"$display;border: 2px solid #cccccc;-moz-border-radius: 15px;
border-radius: 15px;padding: 10px 10px 5px 10px;\">";
				$ixant=$ivars;
			}
			if ($t[0]=="XL"){
				$titulo_ant=$titulo;
				echo "\n<div id=\"wrapper\">";
				echo "\n<b>".$titulo."</b>\n";
				$titulo_ant="";
			}
		}

		echo "<table border=0 cellspacing=0 width=100% class=listTable>\n";
		if (isset($t[14])) if (substr($t[13],0,1)!="@") $fe.=urlencode('`$$$`'.$t[14]);
		if ($t[0]=="H"){
			$ixTab=$ixTab+1;

			$fondocelda="#ffffff";
			$a=$t[2];
			$pos=strpos($a,"[");
  			if ($pos===false){
			}else{
				$a=substr($a,0,$pos);
  			}
			$a=trim($a);

		//	echo "\n<tr><td width=10><a href=#INICIO><img src=../dataentry/img/61.gif border=0></a></td>";
			//echo "<td>&nbsp;</TD>\n";
  		//	echo "<td colspan=3 bgcolor=#eeefef><a name=pag$ixTab></a><strong>$a</strong></td></tr>\n";
         }else{
 	 		$tipo=$t[0];
 	 		 //ESTO SE PONE PARA LOS CAMBIOS QUE SE HICIERON EN LA FDT EN CUANTO AL TIPO DE CAMPO Y EL TIPO DE INGRESO
			 switch ($t[0]){
				case "OD":
						$t[0]="F" ;
						$t[7]="OD";
				  		break;
				  	case "OC":
				       $t[0]="F";
				       $t[7]="OC";
				  		break;
				    case "ISO":
				       $t[0]="F";
				       $t[7]="ISO";
				  		break;
				    case "DC":
				    	$t[0]="F";
				    	$t[7]="DC";
						break;
					case "AI":
						$t[0]="F";
				    	$t[7]="AI";
			}
  			$tag=$t[1];
  			$subc=rtrim($t[5]);
  			$edit_subc=rtrim($t[6]);
			$nsc=strlen(rtrim($t[5]));
			$ksc="";
			$titulo=$t[2];
			$entryType=$t[7];
			$tipo_e="";
			if ($t[7]=="TB") $tipo_e="TB";
			if ($tipo=="L"){
				//$lin01=$titulo;
       			//if ($lin01=="") $lin01="&nbsp;";
       			//	if ($t[7]!="I") echo "\n<tr><td width=10>&nbsp;</td><td width=10 align=right> &nbsp; </td><td colspan=2  ><b>".$lin01."</b></td></tr>\n";
			}else{
  				if (!isset($valortag[$tag]))
  					$valortag[$tag]="";
  				else
  					$valortag[$tag]=str_replace('"',"&quot;",$valortag[$tag]);
	  			$ayuda="";
		 		if (isset($valortag[$tag]) and $t[0]!="H" and $t[0]!="L"){
   					if ($ver && $valortag[$tag] || !$ver){;
   						if  ($t[7]!="I"){
      						echo "<TR><td bgcolor=#FFFFFF valign=top width=20 nowrap><font size=1>";
      					}
						if ($tag<1000 and $t[7]!="I")
							echo  $tag.$ksc;
						else
							if ($t[7]!="I") echo "&nbsp;";
                        if (isset($t[19]) and $t[19]==1) {
                        	echo " <font color=red size=2>*</font>";
                        	$obligatorio="S";
                        }
     					if ($t[7]!="I")echo "</td>\n";

    	  				$subc=rtrim($t[5]);
    	  				if (substr($subc,0,1)=="-") $subc="_".substr($subc,1);
	      				if (substr($subc,0,1)==" ") $subc="+".substr($subc,1);
    	  				$delimsubc=rtrim($t[6]);
      					if (substr($delimsubc,0,1)==" ") $delimsubc="+".substr($delimsubc,1);
      					if (substr($subc,0,1)==" ") $subc="+"+substr($subc,1);
      					$a=trim($t[12]);
						$c="";
   						$separa="";
   						$autoridades="";
   						if ($t[10]=="D") {
   							$autoridades=$t[11];
   							if ($autoridades=="") $autoridades=$arrHttp["base"];
          				}
   						$Repetible="";
   						if ($t[4]==1) $Repetible="R";
   						$postings=1;
   						if (!$ver){
   							echo "<td valign=top width=50 nowrap>";
   							if ($t[7]!="COMBO" and $t[7]!="COMBORO"){
		     					if ($a!="" or $t[10]=="T"){  //es una lista de autoridades o un tesauro
		     						if ($t[7]!="I" and $t[7]!="TB" and $t[10]!="T" and ($t[10]!="")) echo "<a href='javascript:AbrirIndiceAlfabetico(document.forma1.tag$tag,\"$a\",\"$c\",\"$separa\",\"$autoridades\",\"$autoridades.par\",\"tag$tag\",\"$postings\",\"$Repetible\",\"".urlencode($fe)."\")'><img src=../dataentry/img/defaultButton_list.png border=0 width=16></a>";
		     					    if ($t[7]!="I" and $t[10]=="T") {
		     					    	echo "<a href='javascript:AbrirTesauro(\"tag$tag\",\"".$t[11]."\")'><img src=../dataentry/img/toolbarTesaurus.gif></a>";
		     					    	if (trim($a)!="")
		     					    		$autoridades=$arrHttp["base"];
		     					    		if ($t[12]!="")
		     					    		echo "<br><a href='javascript:AbrirIndiceAlfabetico(document.forma1.tag$tag,\"$a\",\"$c\",\"$separa\",\"$autoridades\",\"$autoridades.par\",\"tag$tag\",\"$postings\",\"$Repetible\",\"".urlencode($fe)."\")'><img src=../dataentry/img/defaultButton_list.png border=0 width=16></a>";
		     					    }
		     					}else{
		     						if ($t[7]!="I") echo "<img src=../dataentry/img/spacer.gif width=16>";
		     					}

                            }
           					if ($tipo=="T"  and $tipo_e!="TB") {
                				if (!isset($arrHttp["wks_a"]))
                                   	$wks_a="";
                    			else
                                    $wks_a=$arrHttp["wks_a"];
					 			if ($t[7]!="I") echo "<a href='javascript:Campos(document.forma1.tag$tag,$ixicampo,\"$fe\",\"$Repetible\",\"$help_url\",\"".$wks_a."\")'><img src=../dataentry/img/s2.png align=top border=0 width=16></a>";
						 		}else{
						 			if ($tipo=="M"){
						 				$fe="";
						 				if (isset($arrHttp["wks_a"])) {
						 					$xxwk=explode('|',$arrHttp["wks_a"]);
						 					if (isset($xxwk[4])){
						 						$fe=$xxwk[4];
						 					}else{
						 						if (isset($arrHttp["wks"]))
						 							$fe=$arrHttp["wks"];
												else
													$fe="";
											}
										}
										if ($t[7]!="I") {
											echo "<img src=../dataentry/img/spacer.gif width=16>";
											echo "<a href='javascript:CampoFijo(document.forma1.tag$tag,$ixicampo,\"$fe\",\"$base\",\"\",\"$help_url\",\"$tag_tipol\",\"$tag_nivelr\")'><img src=../dataentry/img/s2.png  align=top  border=0 width=16></a>";
										}
									}
									if ($tipo=="LDR") {
										if (isset($arrHttp["wks"]))
											$fe=$arrHttp["wks"];
										else
											$fe="";

									}
						 		}
                                $help="";
						 		if (isset($t[16])) $help=$t[16];

					 			if (isset($hlp_tip[$tag]))
					 				echo "<a class=\"tooltip\"><img src=\"../dataentry/img/callout.jpg\"><span>".$hlp_tip[$tag]." </span> </a>";
						 		if ($help==1 or $help_url!=""){
						 			if ($help_url==""){
						 				if ($t[7]!="I") echo "<a href=javascript:Ayuda($tag)><img src=../dataentry/img/question.gif border=0 align=top width=16></a>";
									}else{
										if ($t[7]!="I") echo "<a href='javascript:msgh=window.open(\"$help_url\",\"help\",\"width=600,height=400\");msgh.focus()'><img src=../dataentry/img/question.gif border=0 align=top width=16></a>";
						 			}
						 		}else{
						 			if ($t[7]!="I") echo "<img src=../dataentry/img/spacer.gif width=16>";
								}
		     					echo "</td>\n";
                            }
   		 	 				$nsc=strlen(rtrim($t[5]));
     						$ixicampo=$ixicampo+1;
    						if ($tipo!="T" and $tipo!="M" and $tipo!="AI") $tipo_e=$entryType;
    						//if ($tipo=="AI") $tipo_e="AI";
    						if ($tipo=="T") $tipo_e="E";
    						if ($tipo=="M") $tipo_e="FF";
    						if ($tipo=="LDR") $tipo_e="LDR";
    						if ($tipo=="M5") $tipo_e="M5";
    						if ($entryType=="TB") $tipo_e="TB";
    						//if ($entryType=="ISO") $tipo_e="ISO";
    						//if ($entryType=="RO")  $tipo_e="RO";
//     echo "<input type=hidden name=idtag value=$tag>";
							if (trim($tipo_e)=="") $tipo_e="X";
							if (isset($t[15]))
								if (!$ver and $valortag[$tag]=="") $valortag[$tag]=$t[15];
		        			switch ($tipo_e) {
		        				case "M5":     //DATE OF LAST UPDATE (FIELD 005 MARC)
		        					$is_marc="S";
		        					if (!isset($default_values) or $default_values!="S"){    //CHECK IF EDITING DEFAULT VALUES
	      								$campo=$valortag[$tag];
      									echo "\n<td valign=top width=130>";
      									echo trim($titulo)."</td>\n";
      									echo "\n<td valign=top align=left>\n";
      									if (!$ver) {
      										$campo=date("YmdHi.s");
       										echo "<input type=hidden name=tag$tag id=tag$tag  value=\"".$campo."\" >\n";
       									}
      									echo nl2br($campo);
       									echo "</td><tr>\n";
       								}
   	   								break;
   	   							case "OC":   //OPERATOR WHO CREATED THE RECORD
   	   								if (!isset($default_values) or $default_values!="S"){    //CHECK IF EDITING DEFAULT VALUES
	      								$campo=$valortag[$tag];
      									echo "\n<td valign=top width=130>";
      									echo trim($titulo)."</td>\n";
      									echo "\n<td valign=top align=left>\n";
      									if (!$ver) {
      										if (trim($campo)=="")
      											if ($arrHttp["Mfn"]=='New')$campo=$_SESSION["login"];
       										echo "<input type=text name=tag$tag id=tag$tag value=\"".$campo."\" size=20 onfocus=blur()>\n";
       									}
       									echo "</td><tr>\n";
       								}
   	   								break;
   	   							case "DC":  //DATE THE RECORD WAS CREATED
   	   								if (!isset($default_values) or $default_values!="S"){    //CHECK IF EDITING DEFAULT VALUES
	      								$campo=$valortag[$tag];
      									echo "\n<td valign=top width=130>";
      									echo trim($titulo)."</td>\n";
      									echo "\n<td valign=top align=left>\n";
      									if (!$ver) {
      										if ($campo=="")
      											if ($arrHttp["Mfn"]=='New')$campo=date("Ymd h:i:s");
       										echo "<input type=text name=tag$tag id=tag$tag  value=\"".$campo."\" size=20 onfocus=blur()>\n";
       									}
       									echo "</td><tr>\n";
       								}
   	   								break;
		        				case "OD":     //Operator and date
		        					if ($arrHttp["Opcion"]!="valdef"){    //CHECK IF EDITING DEFAULT VALUES
	      								$campo=$valortag[$tag];
	      								$campo_out="";
      									echo "\n<td valign=top width=130>";
      									if (trim($t[5])=="") $t[5]="od";
      									echo trim($titulo)."</td>\n";
      									echo "\n<td valign=top align=left>\n";
      									//KEEP ONLY THE NUMBER OF OCCURRENCES SPECIFIED IN THE COLUMN ROW OF THE FDT
      									$ccc=explode("\n",$campo);
      									if ($t[8]==0) $t[8]=10;
      									if (count($ccc)>=$t[8]){
      										$campo="";
      										$ix=count($ccc)-$t[8]+1;
      										for ($yx=$ix;$yx<count($ccc);$yx++){
      											if ($campo=="")
      												$campo=$ccc[$yx];
      											else
      												$campo.="\n".$ccc[$yx];
      										}
      									}
      									if ($arrHttp["Opcion"]=="crear") $campo="";
      									if (!$ver ) {
      										if ($reintentar!="S"){
	      										if ($campo!=""){
	      											$campo.="\n"."^".substr($t[5],0,1).date("Ymd h:i:s")."^".substr($t[5],1,1).$_SESSION["login"];
	      										}else{
	      											$campo.="^".substr($t[5],0,1).date("Ymd h:i:s")."^".substr($t[5],1,1).$_SESSION["login"];
	      										}
	      									}
       										echo "<input type=hidden name=tag$tag id=tag$tag value=\"".$campo."\" >\n";
       									}
       									echo "<table bgcolor=#eeeeee>";
       									echo "<tr><td width=150>".$msgstr["it_d"]."</td><td>".$msgstr["dboper"]."</td></tr>";
       									$campo_out=explode("\n",$campo);
       									foreach ($campo_out as $var=>$value){
       										$val=explode('^',$value);
       										echo "<tr><td bgcolor=white>";
       										if (isset($val[1]))
       											echo substr($val[1],1);
       										echo "</td><td bgcolor=white>";
       										if (isset($val[2]))
       											echo substr($val[2],1);
       										echo "</td></tr>";
       									}
       									echo "</table>";
       									echo "<br>";
       									echo "</td><tr>\n";

       								}
   	   								break;
		        				case "LDR":
		        					$is_marc="S";
		        				    $filas=Array();
    	   							$linea01=$vars[$ivars];

                                    $ksc=0;
                                    $ldr_tit=array();
                                    echo "<td valign=top>$titulo</td><td><table cellpadding=0 cellspacing=5  bgcolor=#EEEEEE>";
                                    for ($ixsc=1;$ixsc<=100;$ixsc++){

        								$ivars=$ivars+1;
        								$linea=$vars[$ivars];
        								if (substr($linea,0,1)!="S"){    //para detectar el fin de la descripci�n del leader
        									$ivars=$ivars-1;
        									$ixsc=999;
        								}else{
        									$ksc=$ksc+1;
        									$filas[]=rtrim($linea);
                                            $ld=explode('|',$linea);
                                            $ldr_tit[$ksc]=  "<tr><td>".$ld[2]." (".$ld[1].")</td>";
                                            //echo "<td align=center>".$ld[2]." (".$ld[1].")</td>";
        								}

		       						}
		       						$ksc=0;
       								foreach ($filas as $linea){
       									$ksc=$ksc+1 ;
       									echo $ldr_tit[$ksc];
               							$ld=explode("|",$linea);
                      					echo "<td nowrap>";
                      					$ttmsel="";
	               					    if ($ld[1]==3006){
                   							if (isset($arrHttp["wk_tipom_1"])) {
                   								 $ttmsel=$arrHttp["wk_tipom_1"];
                   							}
                   							if ($ttmsel=="") if (isset($valortag[$ld[1]]))$ttmsel=$valortag[$ld[1]];
                   						}else{
                   							if (isset($valortag[$ld[1]])) $ttmsel=$valortag[$ld[1]];
                   						}
                   						$ldr_tag[$ksc]=$ld[1];
                   						echo "<select name=tag".$ld[1]." id=tag".$ld[1].">\n";
                   						echo "<option value=\"\"></option>\n";
                   						if (file_exists($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$ld[11]))
                   							$fpleader=file($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$ld[11]);
                   						else
                   						    $fpleader=file($db_path.$arrHttp["base"]."/def/".$lang_db."/".$ld[11]);
                   						foreach ($fpleader as $value){

                   							$value=trim($value);
                      						if ($value!=""){
                      							$v=explode("|",$value);
                      							$selected="";
                      							if ( trim($v[0])==trim($ttmsel)) $selected=" selected";
	                      						echo "<option value=".$v[0]."|".$v[2]." $selected>".trim($v[1])."(".$v[0].")</option>\n";
    										}
    									}
    									echo  "</select>";
    									if (isset($_SESSION["permiso"])){
    										if (isset($_SESSION["permiso"]["db_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"]) or  isset($_SESSION["permiso"][$base."_CENTRAL_ALL"])  or  isset($_SESSION["permiso"][$base."_CENTRAL_ACTPICKLIST"])){
    											echo " <a href=\"javascript:AgregarPicklist('".$ld[11]."','tag".$ld[1]."','')\"><img src=../dataentry/img/s2.gif alt='".$msgstr["mod_picklist"]."' title='".$msgstr["mod_picklist"]."' border=0></a>";
											}
											echo " <a href=\"javascript:RefrescarPicklist('".$ld[11]."','tag".$ld[1]."','')\"><img src=../dataentry/img/reset.gif alt='".$msgstr["reload_picklist"]."' title='".$msgstr["reload_picklist"]."' border=0></a> &nbsp; ";
    									}
    									echo "</td>\n";
    									echo "<input type=hidden name=eti$tag value=\"$linea01\">\n";
        							}
                                    echo "</table><br></td></tr>";
       								break;
		        				case "B":      //External HTML
		        					if ($arrHttp["Mfn"]=="New"){
		        						echo "<td><h3><font color=red>you must load the full document as soon as this record is created, using the load icon in the record toolbar</font></h3>";
		        					}else{
    	   								echo "\n<td bgcolor=#FFFFFF valign=top width=150><a href=internal_html.php?base=".$arrHttp["base"]."&Mfn=".$arrHttp["Mfn"]."&tag=$tag target=_blank>$titulo</a>\n";
									}
									//echo "<!-- &nbsp; &nbsp;<a href=javascript:CopiarHtml(".$tag.",'B','".$arrHttp["Mfn"]."')>upload file</a>-->";

									echo "</td><td>";
    	   							echo "</td></tr>";
    	   							break;
								case "A":        //HTMLarea
									echo "<td bgcolor=#FFFFFF valign=top colspan=2>";
									echo "<strong>$titulo</strong>";
									if (!$ver) {
									//	echo "<font size=1 color=red> <i>( ".$msgstr["fck_abrir1"]." <img src=../dataentry/img/toolbar.expand.gif> ".$msgstr["fck_abrir2"].")</i></font><br>";
										DibujarHtmlArea($tag,$vars[$ivars],$t[8],$tipo_e);
										$a=str_replace("'","\"",$valortag[$tag]);
									}else{

										echo "<br><font class=td>".$valortag[$tag];
									}
									echo "</td></tr>\n";
									break;
	      						case "D":
									$campo=$valortag[$tag];
        							echo "\n<td bgcolor=#FFFFFF valign=top width=130>";
       								echo trim($titulo)."</td>\n";
       								echo "\n<td bgcolor=#FFFFFF valign=top>\n";
       								if (!$ver) {
       									$next_field=explode('|',$vars[$ivars+1]);  //IF THE NEXT FIELD IS AN ISO FIELD CALL THE CONVERSION PROCEDURE
       									if (trim($next_field[7])=="ISO"){
       										$date_tag="tag$tag"; //NAME OF THE ACTUAL FIELD FOR GENERATING THE ISO DATE
       										$iso_tag="tag".$next_field[1]; //NAME OF THE ISO FIELD
       									}else{
       										$next_field=explode('|',$vars[$ivars]);
       										if (trim($next_field[0])=="ISO"){
       											$date_tag="tag$tag"; //NAME OF THE ACTUAL FIELD FOR GENERATING THE ISO DATE
       											$iso_tag="tag".$next_field[1]; //NAME OF THE ISO FIELD
       										}else{
       											$date_tag="";
       											$iso_tag="";
       										}
       									}
       									echo "<!-- calendar attaches to existing form element -->
												<input type=text name=tag$tag id=tag$tag"."_c Xreadonly=\"1\"  value=\"$campo\" ";
												if ($iso_tag!="") echo " onChange='Javascript:DateToIso(this.value,document.forma1.$iso_tag)'";
												echo "/>
					 							<img src=\"../dataentry/img/calendar.gif\" id=\"f_tag$tag\" style=\"cursor: pointer;\" title=\"Date selector\"
					     						  />
												 <script type=\"text/javascript\">
											    Calendar.setup({

											        inputField     :    \"tag$tag"."_c\",     // id of the input field
											        ifFormat       :    \"";
											        if ($config_date_format=="DD/MM/YY")    // format of the input field
											        	echo "%d/%m/%Y";
											        else
											        	echo "%m/%d/%Y";
											        echo "\",
											        button         :    \"f_tag$tag\",  // trigger for the calendar (button ID)
											        align          :    '',           // alignment (defaults to \"Bl\")
											        singleClick    :    true
											    });
											</script>";

	       							}else{
    	    							echo $campo;
       								}
	       							echo "</td></tr>\n";
    	   							break;
    	   						case "ISO":
    	   							$campo=$valortag[$tag];
        							echo "\n<td bgcolor=#FFFFFF valign=top width=130>";

       								echo trim($titulo)."</td>\n";

       								if ($t[4]==1){    //SI ES REPETIBLE
       									$field_t=$vars[$ivars];
       									DibujarTextRepetible($tag,$fondocelda,$field_t);
       									break;
       								}
       								echo "\n<td bgcolor=#FFFFFF valign=top>\n";
       								if (!$ver) {
                                        echo "<!-- calendar attaches to existing form element -->
												<input type=text name=tag$tag id=tag$tag"."_c Xreadonly=\"1\"  value=\"$campo\"
												 onChange='Javascript:DateToIso(this.value,document.forma1.tag$tag)'";
												echo "/>
					 							<img src=\"../dataentry/img/calendar.gif\" id=\"f_tag$tag\" style=\"cursor: pointer;\" title=\"Date selector\"
					     						  />
												 <script type=\"text/javascript\">
											    Calendar.setup({

											        inputField     :    \"tag$tag"."_c\",     // id of the input field
											        ifFormat       :    \"";
											        if ($config_date_format=="DD/MM/YY")    // format of the input field
											        	echo "%d/%m/%Y";
											        else
											        	echo "%m/%d/%Y";
											        echo "\",
											        button         :    \"f_tag$tag\",  // trigger for the calendar (button ID)
											        align          :    '',           // alignment (defaults to \"Bl\")
											        singleClick    :    true
											    });
											</script>";

	       							}else{
    	    							echo $campo;
       								}
       								if ($Repetible=="R"){
       									echo "<td>\n</table>";
       									echo "<a href=javascript:addRow('".$tag."','')>".$msgstr["add"]."</a><br><br></td>";
       								}
	       							echo "</td></tr>\n";
    	   							break;
    	   						case "FF":    //MARC Campo fijo
    	   							$is_marc="S";
	    	  						$filas=Array();
    	   							$linea01=rtrim($vars[$ivars]);
                                    $ksc=0;
       								for ($ixsc=1;$ixsc<=100;$ixsc++){

        								$ivars=$ivars+1;
        								$linea=$vars[$ivars];
        								if (substr($linea,0,1)!="S"){
        									$ivars=$ivars-1;
        									$ixsc=999;
        								}else{
        									$ksc=$ksc+1;
        									$filas[]=rtrim($linea);
        								}

		       						}
		       						if (substr($valortag[$tag],0,6)=="aammdd" and $arrHttp["Mfn"]=="New"){
		       							$valortag[$tag]=date("ymd").substr($valortag[$tag],6);
		       						}
		      						TextBox($linea01,$fondocelda,$titulo,$ver,$len,$tag,$ksc,$tipo,$delrep,"");
    		   						echo "<input type=hidden name=eti$tag  value=\"".trim($linea01)."\">\n";
       								foreach($filas as $lin){
       									$lin=trim($lin);
        								echo "<input type=hidden name=eti$tag value=\"$lin\">\n";
       								}
       								break;
	    	  					case "E":
    	   							$filas=Array();
    	   							$linea01=$vars[$ivars];
                                    $sfld=$vars[$ivars+1];
       								$sf=explode('|',$sfld);
       								if ($sf[0]!="S"){
       									for ($nx=0;$nx<count($base_fdt);$nx++){
       										$ll=$base_fdt[$nx];
       										$ll_a=explode('|',$ll);
       										if ($ll_a[1]==$tag){
       											$nsc=strlen(trim($ll_a[5]));
       											for ($ixsc=1;$ixsc<=$nsc;$ixsc++){
			        								$nx=$nx+1;
		    	    								$linea=$base_fdt[$nx];
		        									$filas[]=rtrim($linea);
				    	   						}
       											$nx=9999;
       										}

       									}
       								}else{
       									for ($ixsc=1;$ixsc<=$nsc;$ixsc++){
	        								$ivars=$ivars+1;
    	    								$linea=$vars[$ivars];
        									$filas[]=rtrim($linea);
		    	   						}

       								}

		      						TextBox($linea01,$fondocelda,$titulo,$ver,$len,$tag,$ksc,$tipo,$delrep,"");
    		   						echo "<input type=hidden name=eti$tag value=\"$linea01\">\n";
       								foreach($filas as $lin){
        								echo "<input type=hidden name=eti$tag value=\"$lin\">\n";
       								}
       								break;
       				//			case "M": DibujarCampoFijo($tag,$field_t);
       				//				break;
      							case "T":
      							case "TB":
	       							$filas=Array();
	       							$field_t=$vars[$ivars];
	       							if ($nsc==0){
                                        echo "\n<td bgcolor=#FFFFFF valign=top width=130>$titulo</td>\n";
                                        DibujarTextRepetible($tag,$fondocelda,$field_t);
	       							}else{
	    	   							for ($ixsc=1;$ixsc<=$nsc;$ixsc++){
	        								$ivars=$ivars+1;
	        								$linea=$vars[$ivars];
	    	    							$filas[]=rtrim($linea);
	       								}
	       								DibujarTabla($filas,$tag,$fondocelda,$field_t);
	    							}
         							echo "\n";
    	   							break;
      							case "R":   //Radio button
      								$tope=$t[9];
       								echo "\n<td bgcolor=#FFFFFF valign=top width=130>$titulo</td>\n";
       								$opciones=trim($t[11]);
									$lt=array();
									$lin="";
									$filas=array();
	       							DibujarCheck($filas,$fondocelda,$valortag[$tag],$tag,$opciones,$tope,$tipo_e,$t[5]);
       								break;
      							case "C":  //check box
									$tope=$t[9];
       								echo "\n<td bgcolor=#FFFFFF valign=top width=130>$titulo</td>\n";
    	    						$opciones=trim($t[11]);
    	    						$lt=array();
    	   							DibujarCheck($linea,$fondocelda,$valortag[$tag],$tag,$opciones,$tope,$tipo_e,$t[5]);
       								break;
      							case "S":    //select simple o m�ltiple
      							case "SRO":
      							case "M":
      							case "MRO":

       								if ($t[10]=="D"){
       									TextBox($vars[$ivars],$fondocelda,$titulo,$ver,$len,$tag,$ksc,$rep,$delrep,$ayuda);
       									break;
       								}
       								echo "\n<td bgcolor=#FFFFFF valign=top width=130>$titulo</td>\n";
    		    					$opciones=trim($t[11]);
    	   							DibujarSelect($linea,$fondocelda,$valortag[$tag],$tag,$ksc,$opciones,$rep,$t[5]);
    	   							break;
    	   						case "RP":
    	   							$tope=1;
    	   							echo "\n<td bgcolor=#FFFFFF valign=top width=130>$titulo</td>\n";
    	   							$opciones=1;
    	   							DibujarCheck($filas,$fondocelda,$valortag[$tag],$tag,$opciones,$tope,$tipo_e,$t[5]);
    	   							break;
    	   						case "COMBO":
    	   						case "COMBORO":
    	   							echo "\n<td bgcolor=#FFFFFF valign=top width=130>$titulo</td>\n";
    	   							$width=$t[9];
    	   							if ($width==0) $width=50;
    	   							$width=$width*5.5;
    	   							echo "<td>";
    	   							if ($t[11]=="")
    	   								$p_combo=$arrHttp["base"];
    	   							else
    	   								$p_combo=$t[11];
    	   							ComboBox($tipo_e,$tag,$width,$rep,$t[10],$p_combo,$t[13],$t[12],$db_path,$arrHttp["base"],$valortag[$tag]);
    	   							break;

                                case "AI":     //autoincrement
                                	if ($arrHttp["Mfn"]=="New")
                                		$valortag[$tag]="";
								case "X":
								case "U":
      							default:
      							    if (!isset($ayuda)) $ayuda="";
      								$t=explode('|',$vars[$ivars]);
      								if ($t[9]==0) $t[9]=100;
								 	$len=explode('/',$t[9]);
								 	if (count($len)==1){
 		                            	TextBox($vars[$ivars],$fondocelda,$titulo,$ver,$len,$tag,$ksc,$rep,$delrep,$ayuda);
								 	}else{
	      								if ($Repetible=="R") {
	      									DibujarTextRepetible($tag,$fondocelda,$vars[$ivars]);
	      								}else{
	      									TextBox($vars[$ivars],$fondocelda,$titulo,$ver,$len,$tag,$ksc,$rep,$delrep,$ayuda);
	      								}
                                   	}
	       							break;
	    			 		}
   						}else{

						}
					}
				}
  			}
  			echo "</table>";
 		}
        }
        if ($cargar_texto=="S") {
        	echo "Cargar texto";
        }
       if (isset($titulo_ant) and $titulo_ant!="*" and $numero_secciones>1){
			echo "\n<a href=\"javascript:switchMenu('myvar_$ixant');\" style=\"text-decoration:none \">";
			if (substr($titulo_ant,0,1)!="<"){
				echo "<img src=../dataentry/img/minus.gif border=0 style=\"vertical-align:middle\"> &nbsp;<strong>".$msgstr["cerrar"]."</strong></a> $titulo_ant";
			}else{
				echo $msgstr["cerrar"];
			}
		}
		echo "</div></div><p>\n";
	if ($obligatorio=="S")
		echo "<font color=red>".$msgstr["mandatory_field"]."</font>";
    echo "\n<script>
    function OpenAll(){
    	secciones=new Array()
    	ixs=-1\n";
    foreach ($secciones as $value){
    	echo "
    	ixs=ixs+1
    	secciones[ixs]='$value'\n";

    }
	echo "
		for (isecc=0;isecc<secciones.length;isecc++){
			nx=secciones[isecc]
			switchMenu(nx,isecc)
		}
	";
	echo "}
    </script>\n";
	require_once("../dataentry/javascript_validation.php");
}


?>