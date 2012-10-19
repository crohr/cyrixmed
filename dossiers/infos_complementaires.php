<?php
$titre_page="Infos complémentaires";
require_once "header.inc.php";
// Definition des variables
$select_patient=mysql_query("select * from $table_patients where id=\"$idp\"");
if (mysql_num_rows($select_patient) != 1) { // Verif existence patient
echo "<p class=\"erreur\">Erreur : le patient n'existe pas !</p>";
} else {
$res_infos=mysql_fetch_array($select_patient);	
?>

<table border="0" align="center" width="100%">
	<tr valign="top">
		<td width="50%">
		<table width="100%" border="0" bgcolor="#E2E2EC" cellspacing="0" cellpadding="1" align="center">
			<tr>
				<td>
				<table border="0" cellspacing="0" bgcolor="#F9F9FB" width="100%" valign="top">
					<tr> 
          				<td colspan="4" bgcolor="#E2E2EC"><p class="titre_tab" align="center">Caisse d'assurance</p></td>
       				</tr>
        			<tr valign="top"> 
          				<td><strong>Nom :</strong></td>
          				<td><input type="text" name="nom_caisse" value="<?=$res_infos["nom_caisse"]?>"></td>
        			</tr>
        			<tr valign="top"> 
          				<td><strong>Adresse :</strong></td>
          				<td><input type="text" name="adresse_caisse" value="<?=$res_infos["adresse_caisse"]?>"></td>
        			</tr>
        			<tr valign="top"> 
          				<td><strong>Ville - Code postal :</strong></td>
          				<td><input type="text" name="ville_caisse" value="<?=$res_infos["ville_caisse"]?>"></td>
        			</tr>
      			</table>
				</td>
			</tr>
		</table>
		</td>
		<td width="50%">
		<table width="100%" border="0" bgcolor="#E2E2EC" cellspacing="0" cellpadding="1" align="center">
			<tr>
				<td>
				<table border="0" cellspacing="0" bgcolor="#F9F9FB" width="100%" valign="top">
					<tr> 
          				<td colspan="4" bgcolor="#E2E2EC"><p class="titre_tab" align="center">Mutuelle</p></td>
       				</tr>
        			<tr valign="top">
          				<td><strong>N° Adhérent :</strong></td>
          				<td><input type="text" name="num_adherent" value="<?=$res_infos["num_adherent"]?>"></td>
        			</tr>
        			<tr valign="top"> 
          				<td><strong>Nom :</strong></td>
          				<td><input type="text" name="nom_mutuelle" value="<?=$res_infos["nom_mutuelle"]?>"></td>
        			</tr>
        			<tr valign="top"> 
          				<td><strong>Adresse :</strong></td>
          				<td><input type="text" name="adresse_mutuelle" value="<?=$res_infos["adresse_mutuelle"]?>"></td>
        			</tr>
        			<tr valign="top"> 
          				<td><strong>Ville - Code postal :</strong></td>
          				<td><input type="text" name="ville_mutuelle" value="<?=$res_infos["ville_mutuelle"]?>"></td>
        			</tr>
      			</table>
				</td>
			</tr>
		</table>		
		</td>
	</tr>
</table>
		
<br/>

<table border="0" align="center">			
	<tr>
		<td>			
		<?petit_tab("Infos complémentaires", "infos", "80", "8", $res_infos["infos"], "N", "");?>
		</td>
	</tr>
</table>

<?php
}
require_once "footer.inc.php";
?>
