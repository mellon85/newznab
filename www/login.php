<?php
require_once("config.php");
require_once(WWW_DIR."/lib/page.php");

$page = new Page();

$page->addToBody("onload=\"setFocus('username');\"");
$page->meta_title = "Login";
$page->meta_keywords = "Login";
$page->meta_description = "Login";

if ($page->isPostBack())
{
	if (!isset($_POST["username"]) || !isset($_POST["password"]))
		$page->smarty->assign('error', "Please enter username/password");
	else
	{
		$page->smarty->assign('username', $_POST["username"]);
		$users = new Users();
		$res = $users->getByUsername($_POST["username"]);
		if ($res)
		{
			if ($users->checkPassword($_POST["password"], $res["password"]))
			{
				$users->login($res["ID"]);
				header("Location: ".WWW_TOP."/");
			}
			else
			{
				$page->smarty->assign('error', "Bad username/password");
			}
		}
		else
		{
			$page->smarty->assign('error', "Bad username/password");
		}
	}
}

$page->content = $page->smarty->fetch('login.tpl');
$page->render();

?>