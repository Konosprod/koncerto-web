<?php
	require_once 'vendor/autoload.php';
	require_once 'lib/DbManager.php';

	$db = DbManager::getInstance();

	ob_start();
	var_dump($_POST);
	$res = ob_get_contents();
	ob_end_clean();
	file_put_contents("out.txt", $res);

	if(isset($_POST["oid"]) && ! isset($_POST["tid"])) {
		$sql = "INSERT INTO tests(title, owner) VALUES (:title, :owner)";
		$params = array("title"=>$_POST["t"], "owner" => $_POST["oid"]);

		$db->query($sql, $params);

		$testId = $db->lastInsertId();

		for($i = 0; $i <= $_POST["lid"]; $i++) {
			$sql = "INSERT INTO entries(url, answers, test_fk) VALUES(:u, :a, :t)";
			$params = array("u"=>$_POST["u".$i], "a"=>$_POST["a".$i], "t" => $testId);

			$db->query($sql, $params);
		}

		die($testId);
	}

	if(isset($_POST["oid"]) && isset($_POST["tid"])) {
		$sql = "delete from entries where test_fk = :tid";
		$db->query($sql, array("tid"=>$_POST["tid"]));

		for($i = 0; $i <= $_POST["lid"]; $i++) {
			$sql = "INSERT INTO entries(url, answers, test_fk) VALUES(:u, :a, :t)";
			$params = array("u"=>$_POST["u".$i], "a"=>$_POST["a".$i], "t" => $_POST["tid"]);

			$db->query($sql, $params);
		}

		$sql = "update test set title = :title, owner = :owner where id = :id";
		$params = array("title"=>$_POST["t"], "owner"=>$_POST["oid"], "id"=>$_POST["tid"]);

		die($_POST["tid"]);
	}
?>
