// Script réalisé par http://www.toutjavascript.com
// Modifié par http://www.web-creation-fr.com pour CyrixMED
// Reproduction gratuite à condition de laisser ce commentaire

var ferie=new Array("01/01","01/05","08/05","14/07","15/08","01/11","11/11","25/12");
var tabMois=new Array("Janvier","F&eacute;vrier","Mars","Avril","Mai","Juin","Juillet","Ao&ucirc;t","Septembre","Octobre","Novembre","D&eacute;cembre");
/*
function disp(txt, blocCalendrier) { 
	document.getElementById(blocCalendrier).innerHTML=txt; 
	}
	*/
function estFerie(j,m) {
	var nb=ferie.length;
	var test=false;
	for(var i=0;i<nb;i++) {
		if ((ferie[i].substring(0,2)==j)&&(ferie[i].substring(3,5)==m)) return true;
	}
	return false;
}
function calendrier(blocCalendrier,champDate,jour,mois,annee) {
	var d_jour=new Date();
	if (jour) {	d_jour.setDate(jour); }
	if (mois) { d_jour.setMonth(mois); }
	if (annee) { d_jour.setYear(annee); }
	var a=d_jour.getYear(); if (a<1970) {a=1900+a}
	var m=d_jour.getMonth()+1;
	var d=new Date(a,m-1,1);
	var dfin=new Date(a,m-1,1);
	var nb_jour=31;
	var aff_j="";
	for(var k=32;k>27;k--) {
		dfin.setMonth(m-1);
		dfin.setDate(k);
		if (dfin.getMonth()!=m-1) {nb_jour=k-1;}
	}

	var j1=d.getDay(); if (j1==0) j1=7;
	var jour=0;
	var txt="";
	txt+=("<table class=\"calendrierTable\" cellspacing=\"1\">");
	txt+=("<tr><td colspan=7 class=\"calendrierHeader\">"+tabMois[m-1]+" "+a+"</td></tr>");
	txt+=("<TR align='center'><TD class=\"calendrierTH\">L</TD><TD class=\"calendrierTH\">M</TD><TD class=\"calendrierTH\">M</TD><TD class=\"calendrierTH\">J</TD><TD class=\"calendrierTH\">V</TD><TD class=\"calendrierTH\">S</TD><TD class=\"calendrierTH\">D</TD></TR>");
	for(var i=0;i<6;i++) {
		txt+=("<TR>");
		for (j=0;j<7;j++) {
			jour=7*i+j-j1+2; 
			if (jour<10) {
				jourAvecZero="0"+jour+"";
			} else {
				jourAvecZero=jour;
			}
			if ((d_jour.getMonth()+1)<10) {
				moisAvecZero="0"+(d_jour.getMonth()+1)+"";
			} else {
				moisAvecZero=d_jour.getMonth()+1;
			}
			lien="<a href=\"javascript:majDate('"+blocCalendrier+"','"+champDate+"','"+jourAvecZero+"-"+moisAvecZero+"-"+d_jour.getYear()+"')\">";
	
			aff_j=jour;
			if ((jour==d_jour.getDate())&&(m==d_jour.getMonth()+1)) {aff_j=""+jour+"";}
			if ((7*i+j>=j1-1)&&(jour<=nb_jour)) {
				if ((j==6)||(estFerie(jour,m))) txt+=("<TD class=\"calendrierTD\" align='center'>"+lien+""+aff_j+"</a></TD>");
				else txt+=("<TD class=\"calendrierTD\" align='center'>"+lien+""+aff_j+"</a></TD>");
			}
			else txt+=("<TD class=\"calendrierTD\">&nbsp; </TD>");
		}
		txt+=("</TR>");
	}
	
		if ((d_jour.getMonth()+1)==12) {
			anneeSuivante=d_jour.getYear()+1;
		} else {
			anneeSuivante=d_jour.getYear();
		}
		if ((d_jour.getMonth()-1)==-1) {
			anneePrecedente=d_jour.getYear()-1;
		} else {
			anneePrecedente=d_jour.getYear();
		}
		
		txt+=("<tr><td colspan=\"7\"><a href=\"javascript:calendrier('"+blocCalendrier+"','"+champDate+"','"+d_jour.getDate()+"','"+(d_jour.getMonth()+-1)+"','"+anneePrecedente+"')\"><<</a> | <a href=\"javascript:calendrier('"+blocCalendrier+"','"+champDate+"','"+d_jour.getDate()+"','"+(d_jour.getMonth()+1)+"','"+anneeSuivante+"')\"> >></a> | <a href=\"javascript:fermerCalendrier('"+blocCalendrier+"')\">Fermer</a></td></tr>");
	
		txt+=("</TABLE>");
	document.getElementById(blocCalendrier).innerHTML=txt;
	document.getElementById(blocCalendrier).style.visibility='visible';
}
function majDate(blocCalendrier,champ,date) {
	document.getElementById(champ).value=date;
	fermerCalendrier(blocCalendrier);
}
function fermerCalendrier(blocCalendrier) {
	document.getElementById(blocCalendrier).style.visibility='hidden';
	document.getElementById(blocCalendrier).innerHTML="";
}