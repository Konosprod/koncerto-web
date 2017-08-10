
$(document).ready( function() {
	$("#edit-modal").on("shown.bs.modal", function(e) {
		$("#edit-confirm").click(function() {
			var testId = $("#id-blindtest").val();

			if(testId !== '') {
				document.location.href = "https://koncerto.konosprod.fr/edit.php?id="+testId;
			}
		});
	});

	$("#new-test").click(function() {
		document.location.href = "https://koncerto.konosprod.fr/edit.php";
	});
});
