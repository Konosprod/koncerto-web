<?php
	require_once "lib/DbManager.php";

	if(isset($_GET["tid"])) {
		$db = DbManager::getInstance();

		$sql = "select entries.url, entries.answers from entries where entries.test_fk = :id";
		$stmt = $db->query($sql, array("id" => $_GET["tid"]));

		$entries = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$sql = "select tests.title, tests.owner from tests where tests.id = :id";
		$stmt = $db->query($sql, array("id" => $_GET["tid"]));

		$infos = $stmt->fetch(PDO::FETCH_ASSOC);

		$json = array("title"=>$infos["title"], "owner"=> $infos["owner"], "entries" => $entries);

		header("Content-type: application/json");
		echo(json_encode($json));
	}

?>
