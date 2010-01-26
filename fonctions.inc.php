<?php
function petit_tab($titre, $nom, $cols, $rows, $contenu, $alerte, $liste) {
echo "
<table border=\"0\" bgcolor=\"#E2E2EC\" cellspacing=\"0\" cellpadding=\"1\">
		<tr>
			<td>
			<table border=\"0\" cellspacing=\"0\" bgcolor=\"#F9F9FB\" width=\"100%\" valign=\"top\">
				<tr align=\"center\"> 
          			<td valign=\"top\" bgcolor=\"#E2E2EC\">";					
					if ($liste) {
					echo "<a href=\"javascript:popup('../listes/$liste');\">
					<img src=\"../design/liste.gif\" border=\"0\"></a>&nbsp;";
					}
					if ($alerte=="Y" && $contenu) {
					echo "<font class=\"titre_tab_red\">$titre";
					} else {
					echo "<font class=\"titre_tab\">$titre";
					}
					echo "</td>
       			 </tr>
       			 <tr align=\"center\">
          			<td align=\"center\" valign=\"top\"><nobr>
             		<textarea name=\"$nom\" rows=\"$rows\" cols=\"$cols\" OnClick=\"this.value='\\n'+this.value;\">$contenu</textarea>
            		</nobr></td>
        		</tr>
      		</table>
	   		</td>
		</tr>	
	</table>";
}
function Jour($date) {
$jour=substr("$date",8,2);
return $jour;
}
function Mois($date) {
$mois=substr("$date",5,2);
return $mois;
}
function Annee($date) {
$annee=substr("$date",0,4);
return $annee;
}
function DateFR($date) {
$date_fr=substr("$date",8,2).substr("$date",4,4).substr("$date",0,4);
return $date_fr;
}
function DateEN($date) {
$date_en=substr("$date",6,4).substr("$date",2,4).substr("$date",0,2);
return $date_en;
}
function calcul_age($date_naissance) {
	// Age
	$ddn = "$date_naissance";
	$DATEDUJOUR = date("Y-m-d");
	$DATEFRAN = date("d/m/Y");
	$annais = substr("$ddn", 6, 4);
	$anjour = substr("$DATEFRAN", 6, 4);
	$moisnais = substr("$ddn", 3, 2);
	$moisjour = substr("$DATEFRAN", 3, 2);
	$journais = substr("$ddn", 0, 2);
	$jourjour = substr("$DATEFRAN", 0, 2);
	$age = $anjour-$annais;
	if ($moisjour<$moisnais){$age=$age-1;}
	if ($jourjour<$journais && $moisjour==$moisnais){$age=$age-1;}
return $age;
}
?>