function VerifForm(form) {
	if (form.nom.value=="") {
		alert("Veuillez indiquer un nom pour ce patient !");
		form.nom.focus();
	} 
	else if (form.prenom.value=="") {
		alert("Veuillez indiquer un prénom pour ce patient !");
		form.prenom.focus();
	}
	else {
		form.submit();
	}
}