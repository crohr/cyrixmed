<?php
$titre_page="Ajouter un Dossier Patient";
require_once "header.inc.php";
// Enregistrement idp fantaisiste pour éviter rejet dans actions.php
$_SESSION["idp"]=0;
$provenance=(isset($_GET["provenance"]))?$_GET["provenance"]:"";
?>
<nobr>
<center><a href="../index.php?q=choix_patient">ACCUEIL</a></center>
<script language="Javascript" src="verifications.js"></script>
<form name="tabs" method="post" action="actions.php?q=ajouter&provenance=<?=$provenance?>">
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
          <td><input type="text" name="nom"></td>
        </tr>
        <tr valign="top">
          <td><strong>Née :</strong></td>
          <td><input type="text" name="nom_jf"></td>
        </tr>
        <tr valign="top">
          <td width="28%"><strong>Pr&eacute;nom :</strong></td>
          <td width="28%"><input type="text" name="prenom"></td>
        </tr>
        <tr valign="top">
          <td><strong>Titre :</strong></td>
          <td><select name="titre">
		  <option value="Mr">Mr</option>
		  <option value="Mme">Mme</option>
		  <option value="Mlle">Mlle</option>
		  <option value="Enf">Enf</option>
		  </select></td>
        </tr>
        <tr valign="top">
          <td><strong>Date de naissance :</strong></td>
          <td>
		  	<input type="text" name="dn_jours" size="1" onkeypress="Compter(this,forms[0].dn_mois)"> /
		  	<input type="text" name="dn_mois" size="1" onkeypress="Compter(this,forms[0].dn_annee)"> /
			<input type="text" name="dn_annee" size="4" maxlength="4">
		  </td>
        </tr>
        <tr valign="top">
          <td><strong>Statut :</strong></td>
          <td><input type="text" name="statut"></td>
        </tr>
        <tr valign="top">
          <td><strong>Adresse :</strong></td>
          <td><input type="text" name="adresse"></td>
        </tr>
        <tr valign="top">
          <td><strong>Ville - Code Postal:</strong></td>
          <td><input type="text" name="ville"></td>
        </tr>
      </table>
             </td>
             <td width="50%">
                 <table border="0">
        <tr valign="top">
          <td><strong>Créé le :</strong></td>
          <td>
		  	<input type="text" name="dc_jours" size="1" onkeypress="Compter(this,forms[0].dc_mois)" value="<?=date("d");?>"> /
		  	<input type="text" name="dc_mois" size="1" onkeypress="Compter(this,forms[0].dc_annee)" value="<?=date("m");?>"> /
			<input type="text" name="dc_annee" size="4" maxlength="4" value="<?=date("Y");?>">
			</td>
        </tr>
        <tr valign="top">
          <td width="20%"><strong>N° SECU :</strong></td>
          <td width="24%"><input type="text" name="num_secu"></td>
        </tr>
        <tr valign="top">
          <td><strong>Option-ref :</strong></td>
          <td>
		  	<input type="text" name="or_jours" size="1" onkeypress="Compter(this,forms[0].or_mois)"> /
		  	<input type="text" name="or_mois" size="1" onkeypress="Compter(this,forms[0].or_annee)"> /
			<input type="text" name="or_annee" size="4" maxlength="4">
			</td>
        </tr>
        <tr valign="top">
          <td><strong>CMU :</strong></td>
          <td>
		  	<input type="text" name="cmu_jours" size="1" onkeypress="Compter(this,forms[0].cmu_mois)"> /
		  	<input type="text" name="cmu_mois" size="1" onkeypress="Compter(this,forms[0].cmu_annee)"> /
			<input type="text" name="cmu_annee" size="4" maxlength="4">
			</td>
        </tr>
        <tr valign="top">
          <td><strong>Tel travail :</strong></td>
          <td><input type="text" name="tel_travail"></td>
        </tr>
        <tr valign="top">
          <td><strong>Tel personnel :</strong></td>
          <td><input type="text" name="tel_perso"></td>
        </tr>
        <tr valign="top">
          <td><strong>Profession :</strong></td>
          <td><input type="text" name="profession"></td>
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
          				<td><input type="text" name="nom_caisse"></td>
        			</tr>
        			<tr valign="top"> 
          				<td><strong>Adresse :</strong></td>
          				<td><input type="text" name="adresse_caisse"></td>
        			</tr>
        			<tr valign="top"> 
          				<td><strong>Ville - Code postal :</strong></td>
          				<td><input type="text" name="ville_caisse"></td>
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
          				<td><input type="text" name="num_adherent"></td>
        			</tr>
                                <tr valign="top">
          				<td><strong>Nom :</strong></td>
          				<td><input type="text" name="nom_mutuelle"></td>
        			</tr>
        			<tr valign="top"> 
          				<td><strong>Adresse :</strong></td>
          				<td><input type="text" name="adresse_mutuelle"></td>
        			</tr>
        			<tr valign="top"> 
          				<td><strong>Ville - Code postal :</strong></td>
          				<td><input type="text" name="ville_mutuelle"></td>
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
				petit_tab("Infos complémentaires", "infos", "80", "8", "", "N", "");
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
					petit_tab("ATCD Médicaux", "atcd_medicaux", "40", "8", "", "N", "liste.atcd_medicaux.php");
					?>
					</td>
					<td><?
					petit_tab("Chir Obst", "chirobst", "40", "8", "", "N", "");
					?>
					</td>
				</tr>
				<tr>
					<td><?
					petit_tab("ALD", "ald", "40", "6", "", "Y", "");
					?>
					</td>
					<td><?
					petit_tab("Pathologies chroniques", "pathologies_chroniques", "40", "6", "", "N", "");
					?>
					</td>
				</tr>
				<tr valign="top">
					<td><?
					petit_tab("Surveillance", "surveillance", "40", "4", "", "N", "liste.surveillance.php");
					?>
					</td>
					<td><?
					petit_tab("Correspondants", "correspondants", "40", "4", "", "N", "liste.correspondants.php");
					?>
					</td>
				</tr>
				<tr valign="top">
					<td><?
					petit_tab("Allergies", "allergies", "40", "4", "", "N", "");
					?>
					</td>
					<td><?
					petit_tab("Précautions", "precautions", "40", "4", "", "N", "");
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
									<td><input type="text" name="tabac"></td>
									</tr>
									<tr>
									<td>&raquo; Alcool :</td>
									<td><input type="text" name="alcool"></td>
									</tr>
									<tr>
									<td>&raquo; Terrain :</td>
									<td><input type="text" name="terrain"></td>
									</tr>
									<tr>
									<td>&raquo; Sport :</td>
									<td><input type="text" name="sport"></td>
									</tr>
									<tr>
									<td>&raquo; Autres :</td>
									<td><input type="text" name="autres"></td>
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
					petit_tab("Vaccins", "vaccins", "40", "8", "", "N", "liste.vaccins.php");
					?>
					</td>
				</tr>
				<tr valign="top">
					<td><?
					petit_tab("ATCD familiaux", "atcd_fam", "40", "4", "", "N", "");
					?>
					</td>
					<td><?
					petit_tab("Autres Infos", "autres_infos", "40", "4", "", "N", "");
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
require_once "footer.inc.php";
?>
