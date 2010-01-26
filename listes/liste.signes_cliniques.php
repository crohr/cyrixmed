<?php
require "../config.inc.php";
$table_liste="idoc_liste_signes_cliniques";
$select=mysql_query("select * from $table_liste order by nom ASC");
?>
<html>
<head>
<title>Signes Cliniques</title>
<link href="listes.style.css" rel="stylesheet" type="text/css">

<script language="javascript">
function inserer(valeur)
// on affecte la valeur (.value) dans :
// window.opener : la fenêtre appelante (celle qui a fait la demande)
// .document : son contenu
// .tabs : nom formulaire
{
window.opener.document.observations.observations1.value+=" " + valeur + " ";
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
				<td>Nom</td><td>Commentaire</td><td></td>
			</tr>
			<?php
			$i=1;
			while ($res=mysql_fetch_array($select)) {
			echo "
			<tr class=\"contenu_tab\">
				<td><input type=\"text\" name=\"nom_$i\" size=\"30\" value=\"$res[nom]\" onfocus=\"this.select();\"></td>
				<td>$res[commentaire]</td>
				<td><input type=\"button\" name=\"inserer_qqch\" value=\"Insérer\" onClick=\"javascript:inserer(nom_$i.value);\"></td>
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