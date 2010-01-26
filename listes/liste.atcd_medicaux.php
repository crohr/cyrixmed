<?php
require "../config.inc.php";
$table_liste="idoc_liste_atcd_medicaux";
$select=mysql_query("select * from $table_liste order by atcd ASC");
?>
<html>
<head>
<title>ATCD Médicaux</title>
<link href="listes.style.css" rel="stylesheet" type="text/css">

<script language="javascript">
function inserer(valeur)
// on affecte la valeur (.value) dans :
// window.opener : la fenêtre appelante (celle qui a fait la demande)
// .document : son contenu
// .tabs : nom formulaire
{
window.opener.document.tabs.atcd_medicaux.value="- " + valeur + "\n" +window.opener.document.tabs.atcd_medicaux.value + "";
// on remet le focus sur la fenetre ouvrante
//window.opener.focus();
}
</script>


</head>
<body onLoad="window.resizeTo(400,400);self.focus();">
<table width="100%" border="0" cellpadding="1" cellspacing="0">
	<tr>
		<td>
		<form name="liste">
		<table border="0" width="100%">
			<tr class="titres_tab">
				<td>ATCD</td><td>Précisions</td><td></td>
			</tr>
			<?php
			$i=1;
			while ($res=mysql_fetch_array($select)) {
			echo "
			<tr class=\"contenu_tab\">
				<td><input type=\"text\" name=\"atcd_$i\" size=\"30\" value=\"$res[atcd]\" onfocus=\"this.select();\"></td>
				<td>$res[precisions]</td>
				<td><input type=\"button\" name=\"inserer_qqch\" value=\"Insérer\" onClick=\"javascript:inserer(atcd_$i.value);\"></td>
			</tr>";
			$i++;
			}
			?>
		</table>
		</form>
		</td>
	</tr>
</table>
</body>
</html>