<?php
require "../config.inc.php";
$table_liste="idoc_liste_trucs";
$select=mysql_query("select * from $table_liste order by truc ASC");
?>
<html>
<head>
<title>Trucs</title>
<link href="listes.style.css" rel="stylesheet" type="text/css">

</head>
<body onLoad="window.resizeTo(400,400);self.focus();">
<table width="100%" border="0" cellpadding="1" cellspacing="0">
	<tr>
		<td>
		<form name="liste">
		<table border="0" width="100%">
			<tr class="titres_tab">
				<td>Truc</td><td>Explication</td>
			</tr>
			<?php
			$i=1;
			while ($res=mysql_fetch_array($select)) {
			echo "
			<tr class=\"contenu_tab\">
				<td><input type=\"text\" name=\"truc\" size=\"30\" value=\"$res[truc]\" onfocus=\"this.select();\"></td>
				<td>$res[explication]</td>
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