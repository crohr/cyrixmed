<?php
session_start();
include_once "config.inc.php";
?>
<html>
	<head>
	<title>Accueil - <?=$nom_log?></title>
	<link href="style.css" rel="stylesheet" type="text/css">
	</head>
		<body bgcolor="white">
		<table width="100%" height="60" cellspacing="0" cellpadding="0">
			<tr>
				<td width="181"	><a href="http://oued.net/cyrixmed" target="_blank"><img src="design/logo.jpg" border="0"></a></td>
				<td align="left" bgcolor="#879190"><img src="./design/degrade.jpg" border="0"></td>
			</tr>
		</table>
		<hr style="visibility:hidden" />
		<?php
	    if (!isset($_SESSION["id_doc"]) || !isset($_SESSION["mdp_doc"])) 
	    {
			// Affichage des messages d'erreur
			if (isset($_GET["msg_erreur"])) 
			{
			$msg=Array("1"=>"Erreur !<br>Le compte correspondant au login et au mot de passe entrés n'existe pas ou bien l'une de ces deux informations est invalide.",
			"2"=>"Pour accéder à l'administration, vous devez auparavant vous êtes identifié(e) !",
			"3"=>"Votre session a expiré ! Veuillez vous réidentifier.");
			echo "<p class=\"erreur\">".$msg["".$_GET["msg_erreur"].""]."</p>";
			}
		?>
		<form name="identification" method="post" action="actions.php">
		<input type="hidden" name="q" value="identification"> 
		<p align="center">
		<table class="accueilTable" cellspacing="1" style="width:500px;margin:15px">
			<tr><td class="accueilHeader">Identification</td></tr>
			<tr><td class="accueilTD">
			<table border="0" align="center">
				<tr><td><b>Login :</b></td><td><input type="text" name="id_doc" size="15"></td></tr>
				<tr><td><b>Mot de passe :</b></td><td><input type="password" name="mdp_doc" size="15"></td></tr>
				<tr><td colspan="2"><input type="submit" value="Valider"></td></tr>
			</table>
		</td></tr>
		</table>
		</p>
		</form>
			<!--
			<p align="center">
		    <br />
		    Pour tester la démo en mode docteur :<br>
		    login : docteur<br>
		    mdp : docteur<br>
		    Pour tester la démo en mode secrétaire :<br>
		    login : secretaire<br>
		    mdp : secretaire<br>
		    </p>
		    //-->
		<?php
		} else {
			if (isset($_GET["q"])) { $q=$_GET["q"]; } elseif (isset($_POST["q"])) { $q=$_POST["q"]; } else { $q=""; }
		    $id_doc = $_SESSION["id_doc"];
		    $mdp_doc = $_SESSION["mdp_doc"];
			    $infos_doc = mysql_query("select id from $table_docteurs where id=\"$id_doc\" AND mdp=\"$mdp_doc\" AND activation=\"Y\"");
			    if (mysql_num_rows($infos_doc) != 1) {
				    $_SESSION = array();
					// If it's desired to kill the session, also delete the session cookie.
					// Note: This will destroy the session, and not just the session data!
					if (isset($_COOKIE[session_name()])) {
					   setcookie(session_name(), '', time()-42000, '/');
					}
					// Finally, destroy the session.
					session_destroy();
			        echo "<p class=\"erreur\">Votre session a expiré, veuillez vous réidentifier en cliquant sur le lien ci-dessous.<br />
			        <a href=\"index.php\">&raquo; Retour page d'identification</a></p>";
			        exit();
			    } else {
			switch($q) {				
			case "choix_patient":
			?>
			<script language="Javascript" src="choix_patient.js"></script>
			<form name="choix_patient" method="post" action="#">
			<table class="accueilTable" cellspacing="1" style="width:500px;margin:15px">
				<tr><td class="accueilHeader">Choix du patient</td></tr>
				<tr><td class="accueilTD">
				Affinez votre choix en entrant d'autres lettres :<br>
				<input type="text" name="entree" size="20" onKeyUp="javascript:lettre.maj();" value="<?php if (isset($_POST["initiales"])) { echo $_POST["initiales"]; }?>">	
				<br><br>
				Cliquez sur le patient désiré ci-dessous :<br>
				<select name="patients" size="30" OnClick="top.location=patients.options[patients.selectedIndex].value;" style="width:500px">
				<?php
				$select_patients = mysql_query("select id, nom, nom_jf, prenom from $table_patients where nom like \"$_POST[initiales]%\" order by nom ASC");
				if (mysql_num_rows($select_patients) > 0) {
					while ($res = mysql_fetch_array($select_patients)) {
						echo "<option value=\"actions.php?q=enregistrement_idp&idp=".$res["id"]."\">";
						if (!$res["nom"]) {
							echo $res["nom_jf"];
						} else {
							echo $res["nom"];
						} 
						echo " ".$res["prenom"]."</option>\n";
					} 
				} 
							
				?>
				</select>	
				</td>
				</tr>	
			</table>
			</form>
				<script language="javascript">
				<!--
				lettre = new NomObjets('choix_patient','patients','entree');
				lettre.bldInitial(); 
				choix_patient.entree.focus();
				choix_patient.entree.value=choix_patient.entree.value;
				//-->
				</script>
				<p><a href="index.php">Revenir à l'accueil</a></p>
			<?php
			break;	
				
			default:
                require_once "./calendrier/calendrier.php";
				echo "<p style=\"margin:15px\"><b>Bienvenue ".ucfirst($_SESSION["statut"])." ".strtoupper($_SESSION["nom"])." ".ucfirst($_SESSION["prenom"])."</b></p>";
			    ?>
				<script language="javascript">
				function afficheCalendrier(blocVisible,blocCache) {
					document.getElementById(blocVisible).style.visibility="visible";
					document.getElementById(blocCache).style.visibility="hidden";
					//document.getElementById(blocCache).style.position="absolute";
				}
				</script>
			    	<script language="javascript">
					function calendrierPopup(url, largeur, hauteur) {
						var top=(screen.height-hauteur)/2;
						var left=(screen.width-largeur)/2;
						var fen = window.open(""+url+"","popup","top="+top+", left="+left+", toolbar=0, location=0, directories=0, status=1, scrollbars=1, resizable=1, copyhistory=0, menuBar=0, width="+largeur+", height="+hauteur+"");
						if (self.focus) {
							fen.focus();
						}
					}
					function supprimerRDV(url) {
						if (confirm('Etes-vous sûr(e) de vouloir supprimer ce RDV ?')) {
							window.location=url;
						}
					}
					function supprimerEvenement(url) {
						if (confirm('Etes-vous sûr(e) de vouloir supprimer cet événement sur TOUTE sa durée ?')) {
							window.location=url;
						}
					}
					</script>
					<div id="calendrier">
					<?php
					echo '<table border=0 style="width:500px;margin:15px"><tr><td>Codes couleur :';
					for ($i=0;$i<sizeof($tabDocteursAvecIndices);$i++) {
						echo ' <span style="background-color:'.$tabDocteursAvecIndices[$i][2].'">'.$tabDocteursAvecIndices[$i][1].' '.$tabDocteursAvecIndices[$i][0].'</span>';
					}
					echo '</td></tr>';
					?>
					<?php 
					if ($_SESSION["statut"]=="docteur") {
						$typeCalendrier=(isset($_GET["calendrier"])) ? $_GET["calendrier"] : "journalier";
					} else {
						$typeCalendrier="journalier";
					}
					switch ($typeCalendrier) {
						case "journalier":
							if ($_SESSION["statut"]=="docteur") {
								echo '<tr><td><a href="'.$_SERVER['PHP_SELF'].'?calendrier=mensuel">Afficher le calendrier mensuel</a></td></tr></table>';
							} else {
				
							$params['url_relative']='./calendrier';
		                    $params['cell_width']=100;
		                    $params['typeCalendrier']='mensuel';
		                    $params['simple_calendar']=0;
		                    $params['day_mode']=0;
		                    $params['cell_height']=10;
		                    $params['calendar_id']=2;
		                    $params['link_before_date']=0;
							echo calendar();
						}
							echo '<a name="journalier"></a>';
							$params['url_relative']='./calendrier';
		                    $params['cell_width']=500;
		                    $params['typeCalendrier']='journalier';
		                    $params['simple_calendar']=0;
		                    $params['day_mode']=1;
		                    $params['cell_height']=100;
		                    $params['calendar_id']=1;
		                    $params['link_before_date']=0;
							echo calendar();
							
						break;
						case "hebdomadaire":
						
						break;
						
						case "mensuel":
							echo '<tr><td><a href="'.$_SERVER['PHP_SELF'].'?calendrier=journalier">Afficher le calendrier journalier</a><br /><a href="javascript:calendrierPopup(\'calendrier/ajouterEvenement.php\',\'400\', \'300\');">Ajouter un événement de longue durée (vacances, absence de quelques heures...)</a></td></tr></table>';
							$params['url_relative']='./calendrier';
		                    $params['cell_width']=150;
		                    $params['typeCalendrier']='mensuel';
		                    $params['simple_calendar']=0;
		                    $params['link_before_date']=0;
		                    $params['cell_height']=10;
		                    $params['day_mode']=0;
		                    $params['calendar_id']=2;
							echo calendar();
							
						break;
						default:
						echo "pas de type de calendrier indiqué !";
						break;
					}
                    
		    	?>
		    	</div>
		    	<div>
			    <form name="choix_initiales" method="post" action="<?=$_SERVER["PHP_SELF"]?>?q=choix_patient">
				<table class="accueilTable" cellspacing="1" style="width:500px;margin-left:15px;margin-bottom:10px;">
					<tr><td class="accueilHeader">Ouvrir un dossier patient</td></tr>
					<tr><td class="accueilTD">
					Entrez ci-dessous les premières lettres composant le nom du patient et cliquez sur CHERCHER :<br />
					<input type="text" name="initiales" size="10"> <input type="submit" value="CHERCHER">
					</td></tr>
				</table>
				<table class="accueilTable" cellspacing="1" style="width:500px;margin-left:15px;">
					<tr><td class="accueilHeader">Nouveau dossier</td></tr>
					<tr><td class="accueilTD">
					<a href="dossiers/ajouter.php">CREER UN NOUVEAU DOSSIER</a>
					</td></tr>
				</table>
				</form>
				<script language="javascript">
				<!--
				choix_initiales.initiales.focus();
				choix_initiales.initiales.value=choix_initiales.initiales.value;
				//-->
				</script>
				<br />
				<hr style="width:800px;visibility:hidden" />
				<table class="accueilTable" cellspacing="1" style="width:500px;margin-left:15px;margin-bottom:10px;">
					<tr><td class="accueilHeader">Logout</td></tr>
					<tr><td class="accueilTD">
					<a href="actions.php?q=deconnexion">SE DECONNECTER</a>
					</td></tr>
				</table>
				
				<?php
				if ($_SESSION["statut"]=="docteur") {
				?>	
				<table class="accueilTable" cellspacing="1" style="width:500px;margin-left:15px;margin-bottom:10px;">
					<tr><td class="accueilHeader">Administration</td></tr>
					<tr><td class="accueilTD">
					<a href="./admin/" target="_blank">ACCEDER A L'ADMINISTRATION</a>
					</td></tr>
				</table>
				<!--
				<?php
				}
				if ($_SERVER["REMOTE_ADDR"]=="127.0.0.1") {
				?>
				<table class="accueilTable" cellspacing="1" style="width:500px;margin-left:15px;">
					<tr><td class="accueilHeader">ARRET TOTAL</td></tr>
					<tr><td class="accueilTD">
					<a href="actions.php?q=arretTotal">FERMER TOTALEMENT CYRIXMED (Serveurs + navigateur)</a> (vous pouvez également utiliser le raccourci proposé)<br />
					Notez que cela désactivera l'accès à CyrixMED depuis tous les postes du réseau.
					</td></tr>
				</table>
				<?php
				}
				?>
				//-->
				</div>
				<?php
			break;
				
				
			}
		}
	}//fin vérif id et mdp de session
		
?>
	</body>
</html>