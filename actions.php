<?php
session_start();
include_once "config.inc.php";
if (isset($_GET["q"])) { $q=$_GET["q"]; } else { $q=$_POST["q"]; }
switch($q) {
	case "identification":
		// Vérification existence compte doc
    	if (isset($_POST["id_doc"]) && isset($_POST["mdp_doc"])) {
    		$id_doc = $_POST["id_doc"];
    		$mdp_doc = $_POST["mdp_doc"];
   			$check_doc = mysql_query("select id,statut,nom,prenom from $table_docteurs where id=\"$id_doc\" AND mdp=\"$mdp_doc\" AND activation=\"Y\"");
    		if (mysql_num_rows($check_doc) == 1) { // Si compte existant
    			$res_doc=mysql_fetch_array($check_doc);
        		$_SESSION["id_doc"]=$id_doc;
        		$_SESSION["mdp_doc"]=$mdp_doc;
        		$_SESSION["statut"]=$res_doc["statut"];
        		$_SESSION["nom"]=$res_doc["nom"];
        		$_SESSION["prenom"]=$res_doc["prenom"];
        		header("Location: index.php?" . session_name() . "=" . session_id());
        		exit();
    		} else { // Si compte existe pas
        		header("Location: index.php?msg_erreur=1");
        		exit();
    		} 
		} else { // si pas de login ni mdp rentrés
			header("Location: index.php");
			exit();
		}
    break;
    
    case "enregistrement_idp":
	    if (isset($_GET["idp"])) {    
			$idp = $_GET["idp"];
			$iddoc=$_SESSION["id_doc"];
		    $_SESSION["idp"]=$idp;
		    header("Location: ./dossiers/index.php?" . session_name() . "=" . session_id());
		    exit();
		} else {
			echo "Erreur dans le programme lors de l'enregistrement de l'idp";
		}
    break;
    
    case "deconnexion":
    	$_SESSION = array();

		// If it's desired to kill the session, also delete the session cookie.
		// Note: This will destroy the session, and not just the session data!
		if (isset($_COOKIE[session_name()])) {
		   setcookie(session_name(), '', time()-42000, '/');
		}
		
		// Finally, destroy the session.
		session_destroy();
		header("Location: index.php");
		exit();

    break;
    
    case "arretTotal":
	if ($_SERVER["REMOTE_ADDR"]=="127.0.0.1") {
		$updir = "../../..";
			if (strpos($_SERVER["DOCUMENT_ROOT"], "_vhosts.zmwsc") !== FALSE) $updir .= "\..\..";
					chdir($updir);
					exec("mysql_stop.bat");
					header("Location: /_stopServer.zmwsc");
					exit();
	}
    break;
}
?>