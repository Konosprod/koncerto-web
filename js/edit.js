$(document).ready(function() {
	$("#btn-cancel").click(function() {
		document.location.href = "https://koncerto.konosprod.fr";
	});

	$("#btn-add").click(function() {
		var currentId = lastId;
		lastId++;

		var oldEntry = $("#entry");
		var newEntry = oldEntry.clone();
		oldEntry.removeAttr("id");


		newEntry.find("input[name='u"+currentId+"']").attr("name", "u"+lastId).val("");
		newEntry.find("label[for='u"+currentId+"']").attr("for", "u"+lastId);

		newEntry.find("input[name='a"+currentId+"']").attr("name", "a"+lastId).val("");
		newEntry.find("label[for='a"+currentId+"']").attr("for", "a"+lastId);

		newEntry.appendTo($("#form-blindtest"));
	});

	$("#form-blindtest").submit(function(e) {
		var postData = $(this).serialize() + "&lid="+ lastId;

		if($(this).data("id")) {
			var tid = $(this).data("id");

			if(tid != -1) {
				postData += "&tid="+tid;
			}
		}

		$.ajax({
			url:"/ajax.php",
			type:"POST",
			data:postData,
			success: function(data) {
				$("#textModal").html("Vous pouvez maintenant lancer le blindtest avec l'identifiant : " + data);
			},
			error: function(data) {
				alert("Une erreur est survenue !");
			}

		});

		e.preventDefault();
	});

	$("#btn-save").click(function() {

		if($("#title-test").val() == "") {
			$("#textErrorModal").html("Vous devez un titre à votre blindtest !");
			$("#error-modal").modal("toggle");
			return;
		}

		if($("#id-owner").val() == "") {
			$("#textErrorModal").html("Vous devez entrer votre numéro d'identifiant discord !");
			$("#error-modal").modal("toggle");
			return;
		}

		if($("input[name='u0']").val() == "") {
			$("#textErrorModal").html("Vous devez rentrer au moins la première URL !");
			$("#error-modal").modal("toggle");
			return;
		}

		if($("input[name='a0']").val() == "") {
			$("#textErrorModal").html("Vous devez rentrer au moins la première réponse !");
			$("#error-modal").modal("toggle");
			return;
		}

		$("#form-blindtest").submit();
		$("#save-modal").modal("toggle");
	});

});
