
<?php
/***************************************************************************
             ____  _   _ ____  _              _     _  _   _   _
            |  _ \| | | |  _ \| |_ ___   ___ | |___| || | | | | |
            | |_) | |_| | |_) | __/ _ \ / _ \| / __| || |_| | | |
            |  __/|  _  |  __/| || (_) | (_) | \__ \__   _| |_| |
            |_|   |_| |_|_|    \__\___/ \___/|_|___/  |_|  \___/
            
                       calendrier.php  -  A calendar
                             -------------------
    begin                : June 2002
    Version				 : 2.1 (Jan 04)
    copyleft             : (C) 2002-2003 PHPtools4U.com - Mathieu LESNIAK
	email                : support@phptools4u.com
***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

### French Version
$calendar_txt['french']['monthes'] 	    = array('', 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet',
											'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
$calendar_txt['french']['days']		    = array('Lundi', 'Mardi', 'Mercredi','Jeudi', 'Vendredi', 'Samedi',	'Dimanche');
$calendar_txt['french']['first_day']    = 0;
$calendar_txt['french']['misc'] 	    = array('Mois précédent', 'Mois suivant','Jour précédent', 'Jour suivant');


### English version
$calendar_txt['english']['monthes']     = array('', 'January', 'February', 'March',	'April', 'May', 'June', 'July', 
											'August', 'September', 'October','November', 'December');
$calendar_txt['english']['days']	    = array('Monday', 'Tuesday', 'Wednesday','Thursday', 'Friday', 'Saturday','Sunday');
$calendar_txt['english']['first_day']   = -1;
$calendar_txt['english']['misc']        = array('Previous month', 'Next month', 'Previous day', 'Next day');


											
### Spanish version
$calendar_txt['spanish']['monthes']     = array('', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio',
											'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
$calendar_txt['spanish']['days']        = array('Lunes', 'Martes', 'Mi&eacute;rcoles', 'Jueves', 'Viernes', 'S&aacute;bado', 'Domingo');
$calendar_txt['spanish']['first_day']   = 0;
$calendar_txt['spanish']['misc']        = array('Mes anterior', 'Mes pr&oacute;ximo', 'd&iacute;a anterior', 'd&iacute;a siguiente');
											
### German version
$calendar_txt['german']['monthes']	    = array('', 'Januar', 'Februar', 'M&auml;rz', 'April', 'Mai', 'Juni', 'Juli',
											'August', 'September', 'Oktober','November', 'Dezember');
$calendar_txt['german']['days']         = array('Montag', 'Dienstag', 'Mittwoch', 'Donnerstag','Freitag','Samstag', 'Sonntag');
$calendar_txt['german']['first_day']    = 0;
$calendar_txt['german']['misc']         = array('Vorhergehender Monat', 'Folgender Monat', 'Vorabend', 'Am n&auml;chsten Tag');


function calendar($date = '') {
	Global $link_on_day, $PHP_SELF, $params;
	Global $HTTP_POST_VARS, $HTTP_GET_VARS;
	Global $calendar_txt;
	Global $table_planning,$table_patients,$table_docteurs,$_SESSION;
	Global $_GET;

	### Default Params
	$param_d['url_relative']		= '.';
	$param_d['typeCalendrier']		= '';
	$param_d['calendar_id']			= 1; // Calendar ID
	$param_d['calendar_columns'] 	= 5; // Nb of columns
	$param_d['show_day'] 			= 1; // Show the day bar
	$param_d['show_month']			= 1; // Show the month bar
	$param_d['nav_link']			= 1; // Add a nav bar below
	$param_d['link_after_date']		= 1; // Enable link on days after the current day
	$param_d['link_before_date']	= 0; // Enable link on days before the current day
	$param_d['simple_calendar']		= 0; // Version simple du calendrier ou avec affichage de texte suppl et/ou liens et/ou resultats db dans les cellules

	$param_d['link_on_day']			= '?date=%%dd%%&calendrier=journalier'; // Link to put on each day
	$param_d['font_face']			= 'Verdana, Arial, Helvetica'; // Default font to use
	$param_d['font_size']			= 10; // Font size in px
	
	$param_d['bg_color']			= '#FFFFFF'; 
	$param_d['today_bg_color']		= '#FFFFFF';
	$param_d['font_today_color']	= '#990000';
	$param_d['font_color']			= '#000000';
	$param_d['font_nav_bg_color']	= '#A9B4B3';
	
	$param_d['font_nav_color']		= '#FFFFFF';
	$param_d['font_header_color']	= '#FFFFFF';
	$param_d['border_color']		= '#879190';
	$param_d['use_img']				= 1; // Use gif for nav bar on the bottom
	
	### New params V2
	$param_d['lang']				= 'french';
	$param_d['font_highlight_color']= '#FF0000';
	$param_d['bg_highlight_color']  = '#00FF00';
	$param_d['day_mode']			= 0;
	$param_d['time_step']			= 30;
	$param_d['time_start']			= '0:00';
	$param_d['time_stop']			= '24:00';
	$param_d['highlight']			= array();
    // Can be 'hightlight' or 'text'
    $param_d['highlight_type']      = 'highlight';
    $param_d['cell_width']          = 20;
    $param_d['cell_height']         = 20;
    $param_d['short_day_name']      = 0;
    $param_d['link_on_hour']        = $PHP_SELF.'?hour=%%hh%%';
	
	### /Params
	
	
	### Getting all params
	while (list($key, $val) = each($param_d)) {
		if (isset($params[$key])) {
			$param[$key] = $params[$key];
		}
		else {
			$param[$key] = $param_d[$key];
		}
	}
	
	$monthes_name = $calendar_txt[$param['lang']]['monthes'];
	$param['calendar_columns'] = ($param['show_day']) ? 7 : $param['calendar_columns'];
    
    $date = priv_reg_glob_calendar('date');
	if ($date == '') {
		$timestamp = time();
	}
	else {
		$month 		= substr($date, 4 ,2);
		$day 		= substr($date, 6, 2);
		$year		= substr($date, 0 ,4);
		$timestamp 	= mktime(0, 0, 0, $month, $day, $year);
	}
    
    
	$current_day 		= date("d", $timestamp);
	$current_month 		= date('n', $timestamp);
	$current_month_2	= date('m', $timestamp);
	$current_year 		= date('Y', $timestamp);
    $first_decalage 	= date("w", mktime(0, 0, 0, $current_month, 1, $current_year));
	### Sunday is the _LAST_ day
	$first_decalage		= ( $first_decalage == 0 ) ? 7 : $first_decalage;
	
	
	$current_day_index	= date('w', $timestamp) + $calendar_txt[$param['lang']]['first_day'] - 1;
	$current_day_index	= ($current_day_index == -1) ? 7 : $current_day_index;	
	$current_day_name	= $calendar_txt[$param['lang']]['days'][$current_day_index];
	$current_month_name = $monthes_name[$current_month];
	$nb_days_month 		= date("t", $timestamp);
	
	$current_timestamp 	= mktime(23,59,59,date("m"), date("d"), date("Y"));
	
	### CSS
	$output  = '<style type="text/css">'."\n";
	$output .= '<!--'."\n";
	$output .= '	.calendarNav'.$param['calendar_id'].' 	{  font-family: '.$param['font_face'].'; font-size: '.($param['font_size']-1).'px; font-style: normal; background-color: '.$param['border_color'].'}'."\n";
	$output .= '	.calendarTop'.$param['calendar_id'].' 	{  font-family: '.$param['font_face'].'; font-size: '.($param['font_size']+1).'px; font-style: normal; color: '.$param['font_header_color'].'; font-weight: bold;  background-color: '.$param['border_color'].'}'."\n";
	$output .= '	.calendarToday'.$param['calendar_id'].' {  width:'.$param['cell_width'].';font-family: '.$param['font_face'].'; font-size: '.$param['font_size'].'px; font-weight: bold; color: '.$param['font_today_color'].'; background-color: '.$param['today_bg_color'].';border:2px dotted #879190;text-align:left;}'."\n";
	$output .= '	.calendarDays'.$param['calendar_id'].' 	{  width:'.$param['cell_width'].'; padding:0; margin:0; height:'.$param['cell_height'].'; font-family: '.$param['font_face'].'; font-size: '.($param['font_size']+2).'px; font-style: normal;font-weight:bold; color: '.$param['font_color'].'; background-color: '.$param['bg_color'].';text-align:left;}'."\n";
	$output .= '	.calendarDaysBefore'.$param['calendar_id'].' 	{  z-index:3;width:'.$param['cell_width'].'; padding:0; margin:0; height:'.$param['cell_height'].'; font-family: '.$param['font_face'].'; font-size: '.$param['font_size'].'px; font-style: normal; color: '.$param['font_color'].'; background-color: white; background-image: url('.$param['url_relative'].'/barre.gif);background-repeat:no-repeat;background-position:center center;text-align: center}'."\n";
	$output .= '	.calendarHL'.$param['calendar_id'].' 	{  width:'.$param['cell_width'].'; height:'.$param['cell_height'].';font-family: '.$param['font_face'].'; font-size: '.$param['font_size'].'px; font-style: normal; color: '.$param['font_highlight_color'].'; background-color: '.$param['bg_highlight_color'].';}'."\n";
	$output .= '	.calendarRDV'.$param['calendar_id'].' 	{  z-index:2;font-family: '.$param['font_face'].'; font-size: '.($param['font_size']-1).'px; font-style: normal; color: '.$param['font_today_color'].'; font-weight: normal;}'."\n";
	$output .= '	.calendarHeader'.$param['calendar_id'].'{  font-family: '.$param['font_face'].'; font-size: '.($param['font_size']-1).'px; background-color: '.$param['font_nav_bg_color'].'; color: '.$param['font_nav_color'].';}'."\n";
	$output .= '	.calendarTable'.$param['calendar_id'].' {  background-color: '.$param['border_color'].'; border: 1px '.$param['border_color'].' solid}'."\n";
	$output .= '-->'."\n";
	$output .= '</style>'."\n";
	$output .= '<table border="0" class="calendarTable'.$param['calendar_id'].'" style="margin:15px" cellpadding="2" cellspacing="1">'."\n";
	
	### Displaying the current month/year
	if ($param['show_month'] == 1) {
		$output .= '<tr>'."\n";
		$output .= '	<td colspan="'.$param['calendar_columns'].'" class="calendarTop'.$param['calendar_id'].'">'."\n";
		### Insert an img at will
		if ($param['use_img'] ) {
			$output .= '<img src="'.$param['url_relative'].'/mois.gif">';
		}
		if ( $param['day_mode'] == 1 ) {
			$output .= '		'.$current_day_name.' '.$current_day.' '.$current_month_name.' '.$current_year."\n";
		}
		else {
			$output .= '		Planning de '.$current_month_name.' '.$current_year."\n";
		}
		$output .= '	</td>'."\n";
		$output .= '</tr>'."\n";
	}
	
	### Building the table row with the days
	if ($param['show_day'] == 1 && $param['day_mode'] == 0) {
		$output .= '<tr align="center">'."\n";
		$first_day = $calendar_txt[$param['lang']]['first_day'];
		for ($i = $first_day; $i < 7 + $first_day; $i++) {
			
			$index = ( $i >= 7) ? (7 + $i): $i;
			$index = ($i < 0) ? (7 + $i) : $i;
		    
            $day_name = ( $param['short_day_name'] == 1 ) ? substr($calendar_txt[$param['lang']]['days'][$index], 0, 1) : $calendar_txt[$param['lang']]['days'][$index];
			$output .= '	<td class="calendarHeader'.$param['calendar_id'].'"><b>'.$day_name.'</b></td>'."\n";
		}
		
		$output .= '</tr>'."\n";	
		$first_decalage = $first_decalage - $calendar_txt[$param['lang']]['first_day'];
		$first_decalage = ( $first_decalage > 7 ) ? $first_decalage - 7 : $first_decalage;
	}
	else {
		$first_decalage = 0;	
	}
	
	$int_counter = 0;
	
	// Si on est en mode compliqué, on prend la liste des patients
            if ($param['simple_calendar']!=1) {
					$tabPatients[]=array();
						$selectPatients=mysql_query("select id, nom, nom_jf, prenom from $table_patients");
						while($resPatients=mysql_fetch_array($selectPatients)) {
							$tabPatients[$resPatients['id']]=array($resPatients[1],$resPatients[2],$resPatients[3]);
						}
					}
						
	if ( $param['day_mode'] == 1 ) { // si on est en mode jour
			$output .= '<tr valign="top">'."\n";
	            $outputRDV=afficheRDV($current_day,$current_month,$current_year,$tabPatients,$param);
	            $lienAjouterRDV='[<a href="javascript:calendrierPopup(\''.$param['url_relative'].'/ajouterRDV.php'.str_replace('%%dd%%', $current_year.$current_month_2.$current_day,$param['link_on_day']).'\',400,600);" style="font-size:11px;text-align:left;">Ajouter RDV</a>]';
	            
	            $now=mktime(0, 0, 0, date("m"), date("d"), date("Y"));
            	$loop_timestamp = mktime(0,0,0, $current_month_2, $current_day, $current_year); //timestamp de la cellule actuellement créée par la boucle
            
		            if ($param['link_before_date'] == 0 && $now > $loop_timestamp) {
						$output .= '<td class="calendarDaysBefore'.$param['calendar_id'].'">'.$outputRDV.'</td>'."\n";
					} else {
                		$output .= '	<td class="calendarDays'.$param['calendar_id'].'">'.$lienAjouterRDV.''.$outputRDV.'</td>'."\n";
            		}
			$output .= '</tr>'."\n";	
		
	}
	else { // si on est en mode mois	
	$output .= '<tr align="center" valign="top">';
		# Filling with empty cells at the begining
		for ($i = 1; $i < $first_decalage; $i++) {
			$output .= '<td class="calendarDays'.$param['calendar_id'].'">&nbsp;</td>'."\n";
			$int_counter++;
		}
		### Building the table
		for ($i = 1; $i <= $nb_days_month; $i++) {
			### Do we highlight the current day ?
			$i_2 = ($i < 10) ? '0'.$i : $i;		
		    $highlight_current = ( isset($param['highlight'][date('Ym', $timestamp).$i_2]) );	
			### Row start
			if ( ($i + $first_decalage) % $param['calendar_columns'] == 2 && $i != 1) {
				$output .= '<tr align="center" valign="top">'."\n";
				$int_counter = 0;
			}
			
			$css_2_use = ( $highlight_current ) ? 'HL' : 'Days';
            $txt_2_use = ( $highlight_current && $param['highlight_type'] == 'text') ? '<br>'.$param['highlight'][date('Ym', $timestamp).$i_2] : '';
            
            
            if ($param['simple_calendar']!=1) {
					$outputRDV=afficheRDV($i_2,$current_month_2,$current_year,$tabPatients,$param);
					$lienAjouterRDV='<br /><a href="javascript:calendrierPopup(\''.$param['url_relative'].'/ajouterRDV.php'.str_replace('%%dd%%', $current_year.$current_month_2.$i_2,$param['link_on_day']).'\',400,600);" style="font-weight:bold;font-size:10px;">[AJOUTER RDV]</a>';
            
			} 
            //$current_timestamp 	= mktime(0, 0, 0, $current_month_2, $current_day, $current_year);
            $now=mktime(0, 0, 0, date("m"), date("d"), date("Y"));
            $loop_timestamp = mktime(0,0,0, $current_month, $i, $current_year); //timestamp de la cellule actuellement créée par la boucle
            if ($i == $current_day && $loop_timestamp>=$now) {
				$output .= '<td class="calendarToday'.$param['calendar_id'].'"><div style="text-align:center;"><a href="'.str_replace('%%dd%%', $current_year.$current_month_2.$i_2,$param['link_on_day']).'" style="font-size:12px;color:#C01E1E">'.$i.'</a></div>'.$txt_2_use.''.$lienAjouterRDV.''.$outputRDV.'';
			}
			elseif ($param['link_on_day'] != '') {
				
				if (( ($param['link_after_date'] == 0) && ($current_timestamp < $loop_timestamp)) || (($param['link_before_date'] == 0) && ($current_timestamp >= $loop_timestamp)) ){
					$output .= '<td class="calendarDaysBefore'.$param['calendar_id'].'">'.$i.$txt_2_use.'<br />'.$outputRDV.'';
				}
				else {
					$output .= '<td class="calendar'.$css_2_use.$param['calendar_id'].'"><div style="text-align:center;"><a href="'.str_replace('%%dd%%', $current_year.$current_month_2.$i_2,$param['link_on_day']).'" style="color:#C01E1E">'.$i.'</a></div>'.$txt_2_use.''.$lienAjouterRDV.''.$outputRDV.'';
					
				}
			}
			else {
				$output .= '<td class="calendar'.$css_2_use.$param['calendar_id'].'">'.$i.''.$outputRDV.'';
			}	
			
			$output.= '</td>'."\n";
			$int_counter++;
			
			### Row end
			if (  ($i + $first_decalage) % ($param['calendar_columns'] ) == 1 ) {
				$output .= '</tr>'."\n";	
			}
		}
		$cell_missing = $param['calendar_columns'] - $int_counter;
		
		for ($i = 0; $i < $cell_missing; $i++) {
			$output .= '<td class="calendarDays'.$param['calendar_id'].'">&nbsp;</td>'."\n";
		}
		$output .= '</tr>'."\n";
	}
	### Display the nav links on the bottom of the table
	if ($param['nav_link'] == 1) {
		$previous_month = date("Ymd", 	
								mktime( 12, 
										0, 
										0, 
										($current_month - 1),
										$current_day,
										$current_year
									   )
								);
								
		$previous_day 	= date("Ymd", 	
								mktime( 12, 
										0, 
										0, 
										$current_month,
										$current_day - 1,
										$current_year
									   )
								);
		$next_day 		= date("Ymd", 	
								mktime( 1, 
										12, 
										0, 
										$current_month,
										$current_day + 1,
										$current_year
									   )
								);
		$next_month		= date("Ymd", 	
								mktime( 1, 
										12, 
										0, 
										$current_month + 1,
										$current_day,
										$current_year
									   )
								);
		

		if ($param['use_img']) {
			$g 	= '<img src="'.$param['url_relative'].'/g.gif" border="0">';
			$gg = '<img src="'.$param['url_relative'].'/gg.gif" border="0">';
			$d 	= '<img src="'.$param['url_relative'].'/d.gif" border="0">';
			$dd = '<img src="'.$param['url_relative'].'/dd.gif" border="0">';
		}
		else {
			$g 	= '&lt;';
			$gg = '&lt;&lt;';
			$d = '&gt;';
			$dd = '&gt;&gt;';
		}
			if ($param['typeCalendrier']=="journalier") {
				$next_day_link 		= 'jour suivant <a href="'.$PHP_SELF.'?date='.$next_day.'&calendrier='.$param['typeCalendrier'].'" title="'.$calendar_txt[$param['lang']]['misc'][3].'">'.$d.'</a>'."\n";
				$previous_day_link 	= '<a href="'.$PHP_SELF.'?date='.$previous_day.'&calendrier='.$param['typeCalendrier'].'" title="'.$calendar_txt[$param['lang']]['misc'][2].'">'.$g.'</a> jour précédent'."\n";
				$next_month_link 	= '';
				$previous_month_link 	= '';
			} else {
				$next_day_link		= '';
				$previous_day_link	= '';
				$next_month_link 	= 'Mois suivant <a href="'.$PHP_SELF.'?date='.$next_month.'&calendrier='.$param['typeCalendrier'].'" title="'.$calendar_txt[$param['lang']]['misc'][1].'">'.$dd.'</a>'."\n";
				$previous_month_link 	= '<a href="'.$PHP_SELF.'?date='.$previous_month.'&calendrier='.$param['typeCalendrier'].'" title="'.$calendar_txt[$param['lang']]['misc'][0].'">'.$gg.'</a><br />Mois précédent'."\n";
			}
			
		$output.='</table>';
		$output .= '		<table style="width:400px;height:50px" border="0" >';
		$output .= '		<tr valign="top">'."\n";
		$output .= '			<td align="left">'."\n";
		$output .= 					$previous_month_link;
		$output .= '			</td>'."\n";
		$output .= '			<td align="center">'."\n";
		$output .= 					$previous_day_link;
		$output .= '			</td>'."\n";
		$output .= '			<td align="center">'."\n";
		$output .= 					$next_day_link;
		$output .= '			</td>'."\n";
		$output .= '			<td align="right">'."\n";
		$output .= 					$next_month_link;
		$output .= '			</td>'."\n";
		$output .= '		</tr>';
		$output .= '		</table>';
		
	}
	return $output;
}

function priv_reg_glob_calendar($var) {
	Global $HTTP_GET_VARS, $HTTP_POST_VARS;
	
	if (isset($HTTP_GET_VARS[$var])) {
		return $HTTP_GET_VARS[$var];
	}
	elseif (isset($HTTP_POST_VARS[$var])) {
		return $HTTP_POST_VARS[$var];
	}
	else {
		return '';
	}	
}
$tabDocteurs=array();
$tabDocteursAvecIndices=array();
$selectDocteurs=mysql_query("select id, nom, prenom, couleur from $table_docteurs where activation=\"Y\" AND statut=\"docteur\"");
while ($resDocteurs=mysql_fetch_array($selectDocteurs)) {
	$tabDocteurs[$resDocteurs['id']]=array($resDocteurs['nom'],$resDocteurs['prenom'],$resDocteurs['couleur']);
	$tabDocteursAvecIndices[]=array($resDocteurs['nom'],$resDocteurs['prenom'],$resDocteurs['couleur']);
}
function afficheRDV($jour,$mois,$annee,$tabPatients,$param) {
							global $table_planning,$tabDocteurs,$_GET;
							$dateDebutDeLaCellule=''.$annee.'-'.$mois.'-'.$jour.' 00:00:01';
							$dateFinDeLaCellule=''.$annee.'-'.$mois.'-'.$jour.' 23:59:59';
						if ($_SESSION["statut"]=="docteur") {
							$query="select * from $table_planning where TO_DAYS(\"$dateDebutDeLaCellule\")-TO_DAYS(dateDebut)>=0 AND TO_DAYS(dateFin)-TO_DAYS(\"$dateFinDeLaCellule\")>=0 AND idDocteur=\"".$_SESSION["id_doc"]."\" order by dateDebut ASC";
						} else { // si on est en mode secrétaire, on affiche tous les RDV de tous les docteurs
							$query="select * from $table_planning where TO_DAYS(\"".$dateDebutDeLaCellule."\")-TO_DAYS(dateDebut)>=0 AND TO_DAYS(dateFin)-TO_DAYS(\"".$dateFinDeLaCellule."\")>=0 order by idDocteur ASC";
						}
									// Ajout d'un zéro devant le mois, si besoin est
									$mois2="$mois";									
									if (strlen($mois2)<2) {
										$mois2="0".$mois."";
									} 
						$noteDejaRDV=FALSE;
						$selectRDV=mysql_query($query);
						if (mysql_num_rows($selectRDV)>0) {
							$outputRDV = '<br />
							<table border="0" width="100%">';
							while($resRDV=mysql_fetch_array($selectRDV)) {
								
								$outputRDV.='<tr><td class="calendarRDV'.$param['calendar_id'].'">';
								if ($resRDV['idPatient']!=0 && $param['day_mode'] == 1)  {
									if ($_SESSION["statut"]=="docteur") {
										$backgroundColor="#BFCCFB";
									} else { // si on est en mode secretaire, on surligne les RDV avec la couleur du docteur concerné
										$backgroundColor=$tabDocteurs[$resRDV['idDocteur']][2];
									}
									$outputRDV.='<span style="background-color:'.$backgroundColor.';width:100%;z-index:2">'.substr($resRDV['dateDebut'],11,5).' :<br /><a href="actions.php?q=enregistrement_idp&idp='.$resRDV['idPatient'].'" style="font-size:11px;">';
									// Affichage du nom de jeune fille ou du nom
									if (empty($tabPatients[$resRDV['idPatient']][0])) {
										$outputRDV.=''.$tabPatients[$resRDV['idPatient']][1].'';
									} else {
										$outputRDV.=''.$tabPatients[$resRDV['idPatient']][0].'';
									}
									$outputRDV.=' '.$tabPatients[$resRDV['idPatient']][2].'</a>';
									if ($param['day_mode'] == 1 ) {
										$outputRDV.='<br />'.$resRDV['commentaires'].'';
									}
									$outputRDV.='<br />[<a href="javascript:supprimerRDV(\'./calendrier/supprimerRDV.php?date='.$annee.$mois2.$jour.'&calendrier='.$param['typeCalendrier'].'&id='.$resRDV['id'].'\');" style="color:red">Supprimer le RDV</a>]';
			
								} elseif ($resRDV['idPatient']==0) {
									$outputRDV.='<span style="z-index:2;background-color:'.$tabDocteurs[$resRDV['idDocteur']][2].';color:black;width:100%">'.$resRDV['commentaires'].'';
									$outputRDV.='<br /><a href="javascript:supprimerEvenement(\'./calendrier/supprimerRDV.php?date='.$annee.$mois2.$jour.'&calendrier='.$param['typeCalendrier'].'&id='.$resRDV['id'].'\');" style="color:red">[Supprimer l\'événement]</a></span>';
		
								} else {
									if ($_SESSION["statut"]=="docteur") {
											if (!$noteDejaRDV) {
												$noteDejaRDV=TRUE;
												$outputRDV.='<a href="'.str_replace('%%dd%%', $annee.$mois.$jour,$param['link_on_day']).'" style="text-align:center;font-size:12px"><img src="'.$param['url_relative'].'/rdv.gif" style="float:left;border:1px black solid">Vous avez des rendez-vous ce jour !</a>';
											}
									} else {
										$outputRDV.='<a href="'.str_replace('%%dd%%', $annee.$mois.$jour,$param['link_on_day']).'#journalier" style="background-color:'.$tabDocteurs[$resRDV['idDocteur']][2].';text-align:center;width:100%;font-size:10px">Voir les RDV de '.$tabDocteurs[$resRDV['idDocteur']][1].' '.$tabDocteurs[$resRDV['idDocteur']][0].' ce jour.</a>';
									}
								}
								$outputRDV.='</td></tr>';
							}
							$outputRDV.='</table>';
					} else {
						//$outputRDV='<br />Pas de rendez-vous ce jour';
					}
						return $outputRDV;
				}
?>
