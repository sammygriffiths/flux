<?php

define(APP_DIR, __DIR__.'/../app/');

require_once __DIR__.'/../vendor/autoload.php';
require_once APP_DIR.'bootstrap.php';
require_once APP_DIR.'bin/functions.php';

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

$app->get('/', function () use ($app, $modules) {

	$meta = array(
		'title' => 'Home Page Window Title',
		'keywords' => '',
		'description' => '',
	);

	return $app['twig']->render('index.html.twig', array(
		'meta' => $meta,
		'modules' => $modules,
		'pages' => $pages,
		'title' => 'Home'
	));
});

$app->get('/{module}/{page}', function (Request $request, $module, $page) use ($app) {

	$moduleClean = filter_var($module, FILTER_SANITIZE_STRING);
	$pageClean = filter_var($page, FILTER_SANITIZE_STRING);

	if(false === verifyModuleTemplateExists($moduleClean, $pageClean))
	{
		$app->abort(404);
	}

	return $app['twig']->render($pageClean.'.html.twig', array(
		'test' => $pageClean,
	));
})
->assert('module', implode('|', $modules));

$app->get('/{page}', function ($page) use ($app) {

	$pageClean = filter_var($page, FILTER_SANITIZE_STRING);

	if(false === verifyPageTemplateExists($pageClean))
	{
		$app->abort(404);
	}

	return $app['twig']->render($pageClean.'.html.twig', array(
		'test' => $pageClean
	));
})
->assert('page', implode('|', $pages));

$app->get('/contact', function () use ($app) {
	return 'Contact Page';
});

$app->error( function(\Exception $e, $code) {

	switch($code)
	{
		case 404:
			$message = '404 Not Found Message';
		break;
		default:
			$message = 'Generic Error Message';
		break;
	}
	
	return new Response($message, $code);
});

$app->run();