<?php
$titre_page="Modifier un Dossier Patient";
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
	// Selection titre
	if ($res_infos["titre"]=="Mr") { $selection_mr=" selected";$selection_mme="";$selection_mlle="";$selection_enf=""; }
	if ($res_infos["titre"]=="Mme") { $selection_mr="";$selection_mme=" selected";$selection_mlle="";$selection_enf=""; }
	if ($res_infos["titre"]=="Mlle") { $selection_mr="";$selection_mme="";$selection_mlle=" selected";$selection_enf=""; }
	if ($res_infos["titre"]=="Enf") { $selection_mr="";$selection_mme="";$selection_mlle="";$selection_enf=" selected"; }
	
?>
<nobr>
<center><a href="javascript:history.go(-1);">RETOUR PAGE PRECEDENTE</a> | <a href="../index.php?q=choix_patient">ACCUEIL</a></center>

<script language="Javascript" src="verifications.js"></script>
<form name="tabs" method="post" action="actions.php?q=modifier">
<table border="0" align="center">
	<tr valign="top">
		<td width="50%"<?if ($_SESSION["statut"]!="docteur") {echo " colspan=\"2\" align=\"center\""; }?>>
		<table width="450" border="0" bgcolor="#E2E2EC" cellspacing="0" cellpadding="1" align="center">
			<tr>
				<td>
		                   <table border="0" cellspacing="0" bgcolor="#F9F9FB" width="100%" valign="top">
		                          <tr>
          	                            <td colspan="4" bgcolor="#E2E2EC"><p class="titre_tab" align="center">Donn&eacute;es administratives</p></td>
       	                                   </tr>
        <tr valign="top"> 
            <td width="50%">
                <table border="0">
        <tr>
          <td><strong>Nom :</strong></td>
          <td><input type="text" name="nom" value="<?=$res_infos["nom"]?>"></td>
        </tr>
        <tr valign="top">
          <td><strong>Née :</strong></td>
          <td><input type="text" name="nom_jf" value="<?=$res_infos["nom_jf"]?>"></td>
          </tr>
        <tr valign="top">
          <td width="28%"><strong>Pr&eacute;nom :</strong></td>
          <td width="28%"><input type="text" name="prenom" value="<?=$res_infos["prenom"]?>"></td>
        </tr>
        <tr valign="top">
          <td><strong>Titre :</strong></td>
          <td><select name="titre">
		  <option value="Mr"<?=$selection_mr?>>Mr</option>
		  <option value="Mme"<?=$selection_mme?>>Mme</option>
		  <option value="Mlle"<?=$selection_mlle?>>Mlle</option>
		  <option value="Enf"<?=$selection_enf?>>Enf</option>
		  </select></td>
        </tr>
        <tr valign="top">
          <td><strong>Date de naissance :</strong></td>
          <td>
		  	<input type="text" name="dn_jours" size="1" onclick="this.value='';" onkeypress="Compter(this,forms[0].dn_mois)" value="<?=Jour($res_infos["date_naissance"]);?>"> /
		  	<input type="text" name="dn_mois" size="1" onclick="this.value='';" onkeypress="Compter(this,forms[0].dn_annee)" value="<?=Mois($res_infos["date_naissance"]);?>"> /
			<input type="text" name="dn_annee" size="4" maxlength="4" onclick="this.value='';" value="<?=Annee($res_infos["date_naissance"]);?>">
          </td>
        </tr>
        <tr valign="top">
          <td><strong>Statut :</strong></td>
          <td><input type="text" name="statut" value="<?=$res_infos["statut"]?>"></td>
          </tr>
        <tr valign="top">
          <td><strong>Adresse :</strong></td>
          <td><input type="text" name="adresse" value="<?=$res_infos["adresse"]?>"></td>
          </tr>
        <tr valign="top">
          <td><strong>Ville - Code Postal:</strong></td>
          <td><input type="text" name="ville" value="<?=$res_infos["ville"]?>"></td>
          </tr>
        </table>
   </td>
   <td width="50%">
       <table border="0">
        <tr valign="top">
          <td><strong>Créé le :</strong></td>
          <td>
		  	<input type="text" name="dc_jours" size="1" onclick="this.value='';" onkeypress="Compter(this,forms[0].dc_mois)" value="<?=Jour($res_infos["creation_dossier"]);?>"> /
		  	<input type="text" name="dc_mois" size="1" onclick="this.value='';" onkeypress="Compter(this,forms[0].dc_annee)" value="<?=Mois($res_infos["creation_dossier"]);?>"> /
			<input type="text" name="dc_annee" size="4" maxlength="4" onclick="this.value='';" value="<?=Annee($res_infos["creation_dossier"]);?>"></td>
        </tr>
        <tr valign="top">
          <td width="20%"><strong>N° SECU :</strong></td>
          <td width="24%"><input type="text" name="num_secu" value="<?=$res_infos["num_secu"]?>"></td>
        </tr>
        <tr valign="top">
          <td><strong>Option-ref :</strong></td>
          <td>
		  	<input type="text" name="or_jours" size="1" onclick="this.value='';" onkeypress="Compter(this,forms[0].or_mois)" value="<?=Jour($res_infos["option_ref"]);?>"> /
		  	<input type="text" name="or_mois" size="1" onclick="this.value='';" onkeypress="Compter(this,forms[0].or_annee)" value="<?=Mois($res_infos["option_ref"]);?>"> /
			<input type="text" name="or_annee" size="4" maxlength="4" onclick="this.value='';" value="<?=Annee($res_infos["option_ref"]);?>"></td>
        </tr>
        <tr valign="top">
        <td><strong>CMU :</strong></td>
          <td>
		  	<input type="text" name="cmu_jours" size="1" onclick="this.value='';" onkeypress="Compter(this,forms[0].cmu_mois)" value="<?=Jour($res_infos["cmu"]);?>"> /
		  	<input type="text" name="cmu_mois" size="1" onclick="this.value='';" onkeypress="Compter(this,forms[0].cmu_annee)" value="<?=Mois($res_infos["cmu"]);?>"> /
			<input type="text" name="cmu_annee" size="4" maxlength="4" onclick="this.value='';" value="<?=Annee($res_infos["cmu"]);?>"></td>
        </tr>
        <tr valign="top">
          <td><strong>Tel travail :</strong></td>
          <td><input type="text" name="tel_travail" value="<?=$res_infos["tel_travail"]?>"></td>
        </tr>
        <tr valign="top">
          <td><strong>Tel personnel :</strong></td>
          <td><input type="text" name="tel_perso" value="<?=$res_infos["tel_perso"]?>"></td>
        </tr>
        <tr valign="top">
          <td><strong>Profession :</strong></td>
          <td><input type="text" name="profession" value="<?=$res_infos["profession"]?>"></td>
        </tr>
      </table>
              </td>
      </tr>
  </table>
					</td>
				</tr>
			</table>
			
		<br/>
		
		<table border="0" align="center" width="450">
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
				<?
				petit_tab("Infos complémentaires", "infos", "80", "8", $res_infos["infos"], "N", "");
				?>
				</td>
			</tr>
		</table>		
		<br><br><br><br><br>
		<center>
		<input type="button" value="ENREGISTRER" onclick="javascript:VerifForm(this.form)">
		</center>
		</td>
		
		<?if ($_SESSION["statut"]=="docteur") {?>
		<td width="50%">
			<table border="0" align="center">
				<tr valign="top">
					<td><?
					petit_tab("ATCD Médicaux", "atcd_medicaux", "40", "8", $res_infos["atcd"], "N", "liste.atcd_medicaux.php");
					?>
					</td>
					<td><?
					petit_tab("Chir Obst", "chirobst", "40", "8", $res_infos["chirobst"], "N", "");
					?>
					</td>
				</tr>
				<tr>
					<td><?
					petit_tab("ALD", "ald", "40", "6", $res_infos["ald"], "Y", "");
					?>
					</td>
					<td><?
					petit_tab("Pathologies chroniques", "pathologies_chroniques", "40", "6", $res_infos["pathologies_chroniques"], "N", "");
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
				<tr valign="top">
					<td><?
					petit_tab("Allergies", "allergies", "40", "4", $res_infos["allergies"], "N", "");
					?>
					</td>
					<td><?
					petit_tab("Précautions", "precautions", "40", "4", $res_infos["precautions"], "N", "");
					?>
					</td>
				</tr>
				<tr valign="top">
					<td>
					<table border="0" bgcolor="#E2E2EC" cellspacing="0" cellpadding="1" align="center">
						<tr>
							<td>
							<table border="0" cellspacing="0" bgcolor="#F9F9FB" width="100%" valign="top">
								<tr align="center" valign="top"> 
          							<td bgcolor="#E2E2EC">
									<p class="titre_tab" align="center">Habitudes</p>
									</td>
       			 				</tr>
       			 				<tr align="center" valign="top">
          							<td align="center">
									<table border="0" width="220">
									<tr>
									<td>&raquo; Tabac :</td>
									<td><input type="text" name="tabac" value="<?=$res_infos["tabac"]?>"></td>
									</tr>
									<tr>
									<td>&raquo; Alcool :</td>
									<td><input type="text" name="alcool" value="<?=$res_infos["alcool"]?>"></td>
									</tr>
									<tr>
									<td>&raquo; Terrain :</td>
									<td><input type="text" name="terrain" value="<?=$res_infos["terrain"]?>"></td>
									</tr>
									<tr>
									<td>&raquo; Sport :</td>
									<td><input type="text" name="sport" value="<?=$res_infos["sport"]?>"></td>
									</tr>
									<tr>
									<td>&raquo; Autres :</td>
									<td><input type="text" name="autres" value="<?=$res_infos["autres"]?>"></td>
									</tr>
									</table>
             						</td>
        						</tr>
      						</table>
	   						</td>
						</tr>	
					</table>
					</td>
					<td><?
					petit_tab("Vaccins", "vaccins", "40", "8", $res_infos["vaccins"], "N", "liste.vaccins.php");
					?>
					</td>
				</tr>
				<tr valign="top">
					<td><?
					petit_tab("ATCD familiaux", "atcd_fam", "40", "4", $res_infos["atcd_fam"], "N", "");
					?>
					</td>
					<td><?
					petit_tab("Autres Infos", "autres_infos", "40", "4", $res_infos["autres_infos"], "N", "");
					?>
					</td>
				</tr>
			</table>
		</td>
		<?}?>
	</tr>
</table>
</form>
<?php
}
require_once "footer.inc.php";
?>
