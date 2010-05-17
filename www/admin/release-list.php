<?php

require_once("config.php");
require_once(WWW_DIR."/lib/adminpage.php");
require_once(WWW_DIR."/lib/releases.php");
define("ITEMS_PER_PAGE", "25");

$page = new AdminPage();

$releases = new Releases();

$page->title = "Release List";

$releasecount = $releases->getCount();

$offset = isset($_REQUEST["offset"]) ? $_REQUEST["offset"] : 0;
$page->smarty->assign('pagertotalitems',$releasecount);
$page->smarty->assign('pageroffset',$offset);
$page->smarty->assign('pageritemsperpage',ITEMS_PER_PAGE);
$page->smarty->assign('pagerquerybase', "/admin/release-list.php?offset=");
$pager = $page->smarty->fetch("pager.tpl");
$page->smarty->assign('pager', $pager);

$releaselist = $releases->getRange($offset, ITEMS_PER_PAGE);
$page->smarty->assign('releaselist',$releaselist);	

$page->content = $page->smarty->fetch('admin/release-list.tpl');
$page->render();

?>