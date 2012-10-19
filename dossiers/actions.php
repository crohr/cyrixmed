<?php
session_start();
if (!isset($_SESSION["id_doc"]) || !isset($_SESSION["mdp_doc"]) || !isset($_SESSION["idp"])) {
    header ("Location: ../index.php");
    exit();
} else {
    $idp = $_SESSION["idp"];
    $id_doc = $_SESSION["id_doc"];
    $mdp_doc = $_SESSION["mdp_doc"];
    require_once "../config.inc.php";
    $infos_doc = mysql_query("select id from $table_docteurs where id=\"$id_doc\" AND mdp=\"$mdp_doc\" AND activation=\"Y\"");
    if (mysql_num_rows($infos_doc) != 1) {
        echo "<p class=\"erreur\" align=\"center\">Vos identifiants d'accès sont invalides. Veuillez réessayer.</p>";
        exit();
    } else {
        require_once "../fonctions.inc.php";
		if (isset($_GET["q"])) { $q=$_GET["q"]; } else { $q=$_POST["q"]; }
        	switch ($q) {	                
	        // /
	        // // TESTS
	        // /	                
	        case "1";
	            $select = mysql_query("select creation_dossier from $table_patients");
	            while ($res = mysql_fetch_array($select)) {
	                $newdate = DateEN($res["creation_dossier"]);
	                echo "$res[creation_dossier] -> $newdate<br>";
	                $update = mysql_query("update $table_patients set creation_dossier2=$newdate where id=\"$res[id]\"");
	        	} 
	        break;
	
		    case "enr_ordonnance":
		        $medicaments_ald = $_POST["medicaments_ald"];
		        $medicaments = $_POST["medicaments"];
		        // Sauvegarde de l'ordonnance
		        if ($_POST["sauvegarder_ordonnance"] == "oui") {
		            $update = mysql_query("update $table_patients set sauv_ordonnance_medic=\"$medicaments\", sauv_ordonnance_medicald=\"$medicaments_ald\" where id=\"$idp\"");
		        } 
		        if ($update == true) {
		            Header ("Location: index.php");
		            exit;
		        } else {
		            echo "Erreur lors de l'enregistrement des modifications. Veuillez réessayer.";
		        } 
		        break;
		    
		    // /
		    // // Enregistrement ORDONNANCE
		    // /
		    
		    case "ordonnances";
		        $medicaments_ald = $_POST["medicaments_ald"];
		        $medicaments = $_POST["medicaments"];
		        // Sauvegarde de l'ordonnance
		        if ($_POST["sauvegarder_ordonnance"] == "oui") {
		            $update = mysql_query("update $table_patients set sauv_ordonnance_medic=\"$medicaments\", sauv_ordonnance_medicald=\"$medicaments_ald\" where id=\"$idp\"");
		        } 
		        if ($medicaments_ald) {
		            $type = "ald";
		        } 
		        // Sauvegarde ordonnance pour impression
		        $update = mysql_query("update $table_docteurs set sauv_medic=\"$medicaments\", sauv_medicald=\"$medicaments_ald\" where id=\"$id_doc\"");
		
		        ?>
				<html>
				<head>
				<title>Ordonnance - <?=$nom_log?></title>
				</head>
				<frameset rows="1,*">
					<frame src="ordonnances.php?duplicata=oui&type=<?=$type?>">
					<frame src="ordonnances.php?duplicata=non&type=<?=$type?>">
				</frameset>
				</html>
				<?php
		    break;
		    
		    // /
		    // // UPDATE DES OBSERVATIONS
		    // /
		    
		    case "observations";
		        $T = $_POST["T"];
		        $P = $_POST["P"];
		        $TA = $_POST["TA"];
		        $Pi = $_POST["Pi"];
		        if ($T) {
		            $sup = "$T" . "cm - ";
		        } 
		        if ($P) {
		            $sup .= "$P" . "kg - ";
		        } 
		        if ($TA) {
		            $sup .= "$TA" . " - ";
		        } 
		        if ($Pi) {
		            $sup .= "$Pi" . "/min";
		        } 
		        if ($sup) {
		            $sup .= "";
		        } 
		        $observations = "$_POST[observations1] $sup\n$_POST[observations2]";
		        $update = mysql_query("update $table_patients set observations=\"$observations\" where id=\"$idp\"");
		        if ($update == true) {
		            Header ("Location: index.php");
		            exit;
		        } else {
		            echo "Erreur lors de l'enregistrement des modifications. Veuillez réessayer.";
		        } 
		    break;
		    
		    // /
		    // // AJOUT NOUVEAU PATIENT
		    // /
		    
		    case "ajouter";
		        $check_patient = mysql_query("select id from $table_patients where nom=\"$_POST[nom]\" AND prenom=\"$_POST[prenom]\"");
		        if (mysql_num_rows($check_patient) == 1) {
		            echo "<font face=\"verdana\" size=\"2\" color=\"red\">
					ERREUR !<br>
					Ce patient existe déjà. Veuillez retourner à l'accueil le choisir dans la liste.<br><br>
					&raquo <a href=\"../index.php?q=choix_patient\">RETOUR A L'ACCUEIL</a>
					</font>";
		        } else {
		            if ($_SESSION["statut"]=="docteur") {
		                $requete_doc = ",
						atcd=\"$_POST[atcd_medicaux]\",
						atcd_fam=\"$_POST[atcd_fam]\",
						autres_infos=\"$_POST[autres_infos]\",
						ald=\"$_POST[ald]\",
						chirobst=\"$_POST[chirobst]\",
						precautions=\"$_POST[precautions]\",
						allergies=\"$_POST[allergies]\",
						surveillance=\"$_POST[surveillance]\",
						correspondants=\"$_POST[correspondants]\",
						pathologies_chroniques=\"$_POST[pathologies_chroniques]\",
						vaccins=\"$_POST[vaccins]\",
						sport=\"$_POST[sport]\",
						tabac=\"$_POST[tabac]\",
						alcool=\"$_POST[alcool]\",
						terrain=\"$_POST[terrain]\",
						autres=\"$_POST[autres]\"";
		            } 
		            $creation_dossier = "$_POST[dc_annee]-$_POST[dc_mois]-$_POST[dc_jours]";
		            $date_naissance = "$_POST[dn_annee]-$_POST[dn_mois]-$_POST[dn_jours]";
		            $date_cmu = "$_POST[cmu_annee]-$_POST[cmu_mois]-$_POST[cmu_jours]";
		            $date_option_ref = "$_POST[or_annee]-$_POST[or_mois]-$_POST[or_jours]";
		            $insert = mysql_query("insert into $table_patients set
					titre=\"$_POST[titre]\",
					nom=\"$_POST[nom]\",
					nom_jf=\"$_POST[nom_jf]\",
					prenom=\"$_POST[prenom]\",
					date_naissance=\"$date_naissance\",
					statut=\"$_POST[statut]\",
					adresse=\"$_POST[adresse]\",
					ville=\"$_POST[ville]\",
					num_secu=\"$_POST[num_secu]\",
					profession=\"$_POST[profession]\",
					tel_perso=\"$_POST[tel_perso]\",
					tel_travail=\"$_POST[tel_travail]\",
					cmu=\"$date_cmu\",
					option_ref=\"$date_option_ref\",
					infos=\"$_POST[infos]\",
					creation_dossier=\"$creation_dossier\",
					num_adherent=\"$_POST[num_adherent]\",
					nom_mutuelle=\"$_POST[nom_mutuelle]\",
					adresse_mutuelle=\"$_POST[adresse_mutuelle]\",
					ville_mutuelle=\"$_POST[ville_mutuelle]\",
					nom_caisse=\"$_POST[nom_caisse]\",
					adresse_caisse=\"$_POST[adresse_caisse]\",
					ville_caisse=\"$_POST[ville_caisse]\"$requete_doc
					");
		            if ($insert == true) {
		                $idp = mysql_insert_id();
		                if (!empty($_GET["provenance"])) { // si le nouveau dossier a été créé par une popup par exemple, on exécute une action particulière
			                echo 'insertion OK. Actualisation en cours...
							<script language="javascript">
							opener.location.reload();
							this.close();
							</script>';
						} else {
		               		$_SESSION["idp"]=$idp;
		                	Header ("Location: index.php");
	                	}
		            } else {
		                echo "<font face=\"verdana\" size=\"2\" color=\"red\">
						Erreur lors de l'enregistrement des données, veuillez réessayer.
						<br><br>
						&raquo <a href=\"javascript:history.go(-1);\">RETOUR</a>
						</font>";
		            } 
		        } 
		    break;
		    
		    // /
		    // // MODIFIER PATIENT
		    // /
		    
		    case "modifier";
		
		        if ($_SESSION["statut"]=="docteur") {
		            $requete_doc = ",
					atcd=\"$_POST[atcd_medicaux]\",
					atcd_fam=\"$_POST[atcd_fam]\",
					autres_infos=\"$_POST[autres_infos]\",
					ald=\"$_POST[ald]\",
					chirobst=\"$_POST[chirobst]\",
					precautions=\"$_POST[precautions]\",
					allergies=\"$_POST[allergies]\",
					surveillance=\"$_POST[surveillance]\",
					correspondants=\"$_POST[correspondants]\",
					pathologies_chroniques=\"$_POST[pathologies_chroniques]\",
					vaccins=\"$_POST[vaccins]\",
					sport=\"$_POST[sport]\",
					tabac=\"$_POST[tabac]\",
					alcool=\"$_POST[alcool]\",
					terrain=\"$_POST[terrain]\",
					autres=\"$_POST[autres]\"";
		        } 
		
		        $creation_dossier = "$_POST[dc_annee]-$_POST[dc_mois]-$_POST[dc_jours]";
		        $date_naissance = "$_POST[dn_annee]-$_POST[dn_mois]-$_POST[dn_jours]";
		        $date_cmu = "$_POST[cmu_annee]-$_POST[cmu_mois]-$_POST[cmu_jours]";
		        $date_option_ref = "$_POST[or_annee]-$_POST[or_mois]-$_POST[or_jours]";
		        $update = mysql_query("update $table_patients set
				titre=\"$_POST[titre]\",
				nom=\"$_POST[nom]\",
				nom_jf=\"$_POST[nom_jf]\",
				prenom=\"$_POST[prenom]\",
				date_naissance=\"$date_naissance\",
				statut=\"$_POST[statut]\",
				adresse=\"$_POST[adresse]\",
				ville=\"$_POST[ville]\",
				num_secu=\"$_POST[num_secu]\",
				profession=\"$_POST[profession]\",
				tel_perso=\"$_POST[tel_perso]\",
				tel_travail=\"$_POST[tel_travail]\",
				cmu=\"$date_cmu\",
				option_ref=\"$date_option_ref\",
				infos=\"$_POST[infos]\",
				creation_dossier=\"$creation_dossier\",
				num_adherent=\"$_POST[num_adherent]\",
				nom_mutuelle=\"$_POST[nom_mutuelle]\",
				adresse_mutuelle=\"$_POST[adresse_mutuelle]\",
				ville_mutuelle=\"$_POST[ville_mutuelle]\",
				nom_caisse=\"$_POST[nom_caisse]\",
				adresse_caisse=\"$_POST[adresse_caisse]\",
				ville_caisse=\"$_POST[ville_caisse]\"$requete_doc
				where id=\"$idp\"");
		        if ($update == true) {
		            Header ("Location: index.php");
		        } else {
		            echo "<font face=\"verdana\" size=\"2\" color=\"red\">
					Erreur lors de l'enregistrement des données, veuillez réessayer.
					<br><br>
					&raquo <a href=\"javascript:history.go(-1);\">RETOUR</a>
					</font>";
		        } 
		    break;
		
		    default:
		    break;
	    } 
	} 
}
?>
