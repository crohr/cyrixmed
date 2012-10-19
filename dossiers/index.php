<?php
$titre_page="Dossier Patient";
require_once "header.inc.php";

// Definition des variables
$select_patient=mysql_query("select * from $table_patients where id=\"$idp\"");
if (mysql_num_rows($select_patient) != 1) { // Verif existence patient
echo "<p class=\"erreur\">Erreur : le patient n'existe pas !</p>";
} else {
$res_infos=mysql_fetch_array($select_patient);
/*
	// Nom jeune fille
	if ($res_infos[nom_jf]) { $nom_jf=$res_infos[nom_jf]; }
	else { $nom_jf="<center>X</center>"; }	
	*/
	// Date de naissance Fr
	$date_naissance=DateFR($res_infos["date_naissance"]);
	// Date Création dossier FR
	$creation_dossier=DateFR($res_infos["creation_dossier"]);
	// Date CMU FR
	$cmu=DateFR($res_infos["cmu"]);
	// Date Option ref FR
	$option_ref=DateFR($res_infos["option_ref"]);
	// Age
	$age=calcul_age($date_naissance);
	$age.=" ans";
?>
<nobr><center>
<a href="modifier.php">MODIFIER</a> | 
<a href="../index.php">ACCUEIL</a> | 
<a href="../index.php?q=choix_patient" target=_blank>OUVRIR AUTRE DOSSIER</a></center>
<table border="0" align="center">
	<tr valign="top">
		<td width="500">
		<table width="450" border="0" bgcolor="#CECFF2" cellspacing="0" cellpadding="1" align="center">
			<tr>
				<td>
		<table border="0" cellspacing="0" bgcolor="#F9F9FB" width="100%" valign="top">
		<tr> 
          	<td colspan="4" bgcolor="#CECFF2"><p class="titre_tab" align="center">Donn&eacute;es administratives</p></td>
       	</tr>
        <tr valign="top"> 
          <td><strong>Nom :</strong></td>
          <td colspan="3"><?=$res_infos["nom"]?></td>
        </tr>
        <tr valign="top"> 
          <td><strong>Née :</strong></td>
          <td><?=$res_infos["nom_jf"]?></td>
          <td><strong>Créé le :</strong></td>
          <td><?=$creation_dossier?></td>
        </tr>
        <tr valign="top"> 
          <td width="28%"><strong>Pr&eacute;nom :</strong></td>
          <td width="28%"><?=$res_infos["prenom"]?></td>
          <td width="20%"><strong>N° SECU :</strong></td>
          <td width="24%"><?=$res_infos["num_secu"]?></td>
        </tr>
        <tr valign="top"> 
          <td><strong>Titre :</strong></td>
          <td><?=$res_infos["titre"]?></td>
          <td><strong>Option-ref :</strong></td>
          <td><?=$option_ref?></td>
        </tr>
        <tr valign="top"> 
          <td><strong>Date de naissance :</strong></td>
          <td><?=$date_naissance?></td>
          <td><strong>CMU :</strong></td>
          <td><?=$cmu?></td>
        </tr>
        <tr valign="top"> 
          <td><strong>Age :</strong></td>
          <td><?=$age?></td>
          <td><strong>Tel travail :</strong></td>
          <td><?=$res_infos["tel_travail"]?></td>
        </tr>
        <tr valign="top"> 
          <td><strong>Statut :</strong></td>
          <td><?=$res_infos["statut"]?></td>
          <td><strong>Tel personnel :</strong></td>
          <td><?=$res_infos["tel_perso"]?></td>
        </tr>
        <tr valign="top"> 
          <td><strong>Adresse :</strong></td>
          <td><?=$res_infos["adresse"]?><br><?=$res_infos["ville"]?></td>
          <td><strong>Profession :</strong></td>
          <td><?=$res_infos["profession"]?></td>
        </tr>
        <tr valign="top"> 
          <td colspan="4" align="center"><b><a href="javascript:popup_infos('infos_complementaires.php');">Informations complémentaires</a></b></td>
        </tr>
      </table>
					</td>
				</tr>
			</table>
			<br/>
			<form name="tabs">
			<?
			if ($_SESSION["statut"]!="docteur") {?>
			<table border="0" align="center">
				<tr>
					<td>
					<?
					petit_tab("Vaccins", "vaccins", "40", "6", $res_infos["vaccins"], "N", "");
					?>
					</td>
				</tr>
			</table>
			<?}?>
			<?if ($_SESSION["statut"]=="docteur") {?>
			<table border="0" align="center">
				<tr valign="top">
					<td><?
					petit_tab("ATCD Médicaux", "atcd_medicaux", "40", "10", $res_infos["atcd"], "N", "liste.atcd_medicaux.php");
					?>
					</td>
					<td><?
					petit_tab("Chir Obst", "chir_obst", "40", "10", $res_infos["chirobst"], "N", "");
					?>
					</td>
					</tr>
					<tr>
					<td><?
					petit_tab("ALD", "ald", "40", "5", $res_infos["ald"], "Y", "");
					?>
					</td>
					<td><?
					petit_tab("Pathologies chroniques", "pathologies_chroniques", "40", "5", $res_infos["pathologies_chroniques"], "N", "");
					?>
					</td>
				</tr>
				<tr valign="top">
					<td><?
					petit_tab("Surveillance", "surveillance", "40", "4", $res_infos["surveillance"], "N", "liste.surveillance.php");
					?>
					</td>
					<td><?
					petit_tab("Correspondants", "correspondants", "40", "4", $res_infos["correspondants"], "N", "liste.correspondants.php");
					?>
					</td>
					</tr>
					<tr>
					<td><?
					$habitudes="";
					if ($res_infos["tabac"]) {$habitudes.="&raquo; Tabac : ".$res_infos["tabac"]."\n";}
					if ($res_infos["alcool"]) {$habitudes.="&raquo; Alcool : ".$res_infos["alcool"]."\n";}
					if ($res_infos["terrain"]) {$habitudes.="&raquo; Terrain : ".$res_infos["terrain"]."\n";}
					if ($res_infos["sport"]) {$habitudes.="&raquo; Sport : ".$res_infos["sport"]."\n";}
					if ($res_infos["autres"]) {$habitudes.="&raquo; Autres : ".$res_infos["autres"]."\n";}
					petit_tab("Habitudes", "habitudes", "40", "6", $habitudes, "N", "");
					?>
					</td>
					<td><?
					petit_tab("Vaccins", "vaccins", "40", "6", $res_infos["vaccins"], "N", "liste.vaccins.php");
					?>
					</td>
				</tr>		
				<tr>
					<td colspan="2">
					<br><br><br>
					</td>
				</tr>		
				<tr valign="top">
					<td><?
					petit_tab("ATCD familiaux", "atcd_familiaux", "40", "4", $res_infos["atcd_fam"], "N", "");
					?>
					</td>
					<td><?
					petit_tab("Autres Infos", "autres_infos", "40", "4", $res_infos["autres_infos"], "N", "");
					?>
					</td>
				</tr>
			</table>
			</form>
	</td>
			
    <td width="500"> 
    <form name="observations" method="post" action="actions.php?q=observations">
	<table border="0" bgcolor="#C0FFC0" cellspacing="0" cellpadding="1" align="center">
		<tr>
			<td>
			<table border="0" cellspacing="0" bgcolor="#F1FFF1" width="100%" valign="top">
				<tr align="center"> 
          			<td valign="top" bgcolor="#C0FFC0">
					<p class="titre_tab" align="center">Observations</p>
					</td>
       			 </tr>
       			 <tr align="center">
          			<td align="center" valign="top">
             		<textarea name="observations1" rows="2" cols="80"><?= "&raquo $DateJourFR : ";?></textarea><br>
            		<textarea name="observations2" rows="8" cols="80"><?=$res_infos["observations"]?></textarea>
            		</td>
        		</tr>
        		<tr align="center">
          			<td valign="top">
					<nobr>
					<img src="../design/liste.gif" border="0"> <a href="javascript:popup('../listes/liste.signes_cliniques.php');"><b>Clinique</b></a>
					T : <input type="text" name="T" size="4">
					P : <input type="text" name="P" size="4">
					TA : <input type="text" name="TA" size="4">
					Pi : <input type="text" name="Pi" size="4">
					<input type="submit" value="Enregistrer">
					</nobr>
					</td>
        		</tr>
      		</table>
	   		</td>
		</tr>	
	</table>
	</form>
	
	<table border="0" align="center">
				<tr valign="top">
					<td><?
					petit_tab("Allergies", "allergies", "37", "4", $res_infos["allergies"], "Y", "");
					?></td>
					<td><?
					petit_tab("Précautions", "precautions", "37", "4", $res_infos["precautions"], "Y", "");
					?></td>
				</tr>
			</table>
			<script language="javascript">
function Enr_ordonnance(){
var f = document.ordonnance;
f.action="actions.php?q=enr_ordonnance";
f.target="_top";
f.submit();
}
</script>
	<form name="ordonnance" method="post" action="actions.php?q=ordonnances" target="_blank">
	<table border="0" bgcolor="#C0FFC0" cellspacing="0" cellpadding="1" align="center">
		<tr>
			<td bgcolor="white" align="center" style="font-weight:bold">
			&nbsp;&nbsp;<font size="1"><img src="../design/liste.gif" border="0"> <a href="javascript:popup('../listes/liste.medicaments.php');">Médicaments</a></font>
			&nbsp;&nbsp;<font size="1"><img src="../design/liste.gif" border="0"> <a href="javascript:popup('../listes/liste.traitements_locaux.php');">Traitements locaux</a></font>
			&nbsp;&nbsp;<font size="1"><img src="../design/liste.gif" border="0"> <a href="javascript:popup('../listes/liste.trucs.php');">Trucs</a></font>
			<br><br></b></b></td>
		</tr>
		<tr>
			<td>
			<table border="0" cellspacing="0" bgcolor="#F1FFF1" width="100%" valign="top">
				<tr align="center"> 
          			<td valign="top" bgcolor="#C0FFC0">
					<p class="titre_tab" align="center">
					ORDONNANCE
					</p>
					</td>
       			 </tr>
				 <?php
				if ($res_infos["ald"]) {
				?>
				<tr align="center"> 
          			<td valign="top">
					<br/>
					> Médicaments <b>ALD</b> (facultatifs) :
					</td>
       			 </tr>
				 <tr align="center">
          			<td valign="top">
             		<textarea name="medicaments_ald" rows="15" cols="80"><?= $res_infos["sauv_ordonnance_medicald"]."\n";?></textarea>
            		</td>
        		</tr>
				<?php
				}
				?>
				 <tr align="center"> 
          			<td valign="top">
					<br>
					> Médicaments :
					</td>
       			 </tr>
				 <tr align="center">
          			<td valign="top">
             		<textarea name="medicaments" rows="15" cols="80"><?= $res_infos["sauv_ordonnance_medic"]."\n";?></textarea>
            		</td>
        		</tr>
        		<tr align="center">
          			<td valign="top">
					<nobr>
					Voulez-vous enregistrer cette ordonnance ? : 
					<input type="radio" name="sauvegarder_ordonnance" value="oui" onclick="javascript:Enr_ordonnance()">Oui 
					<input type="radio" name="sauvegarder_ordonnance" value="non" checked>Non <br>
					<input type="submit" value="Imprimer"><br>
					</nobr>
					</td>
        		</tr>
      		</table>
	   		</td>
		</tr>	
	</table>
	</form>
	<?}?>
	</td>
</tr>
</table>
</nobr>
<?php
} // Fin verif si existence patient
require_once "footer.inc.php";
?>