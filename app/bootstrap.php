<?php

$app = new Silex\Application();

$app['debug'] = true;

$modules = array('module',);
$pages = array('terms', 'privacy', 'cookies', 'sitemap');

$templateDir = APP_DIR.'/views';

$templatePaths = array(
	$templateDir,
	$templateDir.'/templates',
	$templateDir.'/pages',
);

foreach($modules as $module)
{
	$templatePaths[] = $templateDir.'/'.$module;
}

$app->register(new Silex\Provider\TwigServiceProvider(), array(
	'twig.path' => $templatePaths,
));