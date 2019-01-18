
//Récupérer tous les objets "input"
var nom = document.forms["addMembre"]["nom"];
var prenom = document.forms["addMembre"]["prenom"];
var age = document.forms["addMembre"]["age"];
var ville = document.forms["addMembre"]["ville"];

//Récupérer les erreurs

var erreur_nom = document.getElementById('message');
var erreur_prenom = document.getElementById('message');
var erreur_age = document.getElementById('message');
var erreur_ville = document.getElementById('message');
var success = document.getElementById('message');
//Etablir les écouteurs d'événement

nom.addEventListener("blur", nomVerify, true);
prenom.addEventListener("blur", prenomVerify, true);
age.addEventListener("blur", ageVerify, true);
ville.addEventListener("blur", villeVerify, true);

function Validate(){
	if (nom.value== "") {
		nom.style.border = "1px solid red";
		erreur_nom.textContent = "Veuillez remplir tous les champs";
		nom.focus();
		return false;
	}
	if (prenom.value== "") {
		prenom.style.border = "1px solid red";
		erreur_prenom.textContent = "Veuillez remplir tous les champs";
		prenom.focus();
		return false;
	}
	if (age.value== "") {
		age.style.border = "1px solid red";
		erreur_age.textContent = "Veuillez remplir tous les champs";
		age.focus();
		return false;
	}
	if (ville.value== "") {
		ville.style.border = "1px solid red";
		erreur_ville.textContent = "Veuillez remplir tous les champs";
		ville.focus();
		return false;
	}/*else{
		$success.textContent "Enregistré";
		success.style.color = "blue";
		return true;
	}*/
}

function nomVerify() {
	if (nom.value!= "") {
		nom.style.border = "1px solid darkblue";
		erreur_nom.innerHTML += "";
		return true;
	}
}

function prenomVerify() {
	if (prenom.value!= "") {
		prenom.style.border = "1px solid darkblue";
		erreur_prenom.innerHTML += "";
		return true;
	}
}
function ageVerify() {
	if (age.value!= "") {
		age.style.border = "1px solid darkblue";
		erreur_age.innerHTML += "";
		return true;
	}
}
function villeVerify() {
	if (ville.value!= "") {
		ville.style.border = "1px solid darkblue";
		erreur_ville.innerHTML += "";
		return true;
	}
}

function load_data(is_category)
{
	var dataTable= $('#table_tri').DataTable({
		"processing": true,
		"serverside": true,
		"order": [],
		"ajax": {
			url:"index.php",
			type: "POST",
			data:{is_category:is_category}
		},
		"columnDefs": [
		{
			"targets": [4],
			"orderable": false,
		},
		],
	});
}

// Fonction ajax d'ajout de membre

	$('#addMembre').submit(function(){
		var data = {'nom' :$('#nom').val(), 'prenom' :$('#prenom').val(), 'age' :$('#age').val(), 'ville' :$('#ville').val()};
		
		$.ajax({
			type: "POST",
			data: data,
			url: "index.php",
			success: function(data){
				var data = JSON.parse(data);
				var html = "<table>";
				for(var i = 0; i < data.length; i++)
				{
					html +="<tr>";
					html += "<td>" + data[i].nom + "</td>";
					html += "<td>" + data[i].prenom + "</td>";
					html += "<td>" + data[i].age + "</td>";
					html += "<td>" + data[i].ville + "</td>";
					html += "</tr>";
				}
				html += "</table>";
				$('#membre_table').append(html);
			}
		});
	});
  

