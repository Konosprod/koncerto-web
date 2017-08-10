<?php
	require_once 'vendor/autoload.php';
	require_once 'lib/DbManager.php';


	$loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
	$twig = new Twig_Environment($loader, array("debug"=>true));
	//$twig->addExtension(new Twig_Extension_Debug());

	$template = $twig->loadTemplate("edit.twig");

	if(!isset($_GET["id"])) {
		echo $template->render(array());
	} else {

		$db = DbManager::getInstance();

		$sql = "select * from entries where entries.test_fk = :id";
		$stmt = $db->query($sql, array("id"=>$_GET["id"]));

		$entries = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$lastId = $stmt->rowCount();

		$sql = "select * from tests where tests.id = :id";
		$stmt = $db->query($sql, array("id"=>$_GET["id"]));


		$infos = $stmt->fetch(PDO::FETCH_ASSOC);

		echo $template->render(array(
			"entries" => $entries,
			"infos" => $infos,
			"lastId" => $lastId
		));

	}
?>

