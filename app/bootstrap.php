<?php

$app = new Silex\Application();

$app['debug'] = true;

$modules = array('module',);
$pages = array('terms', 'privacy', 'cookies', 'sitemap', 'contact-success');

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

$app->register(new Silex\Provider\FormServiceProvider());

$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'locale_fallbacks' => array('en'),
));

$app->register(new Silex\Provider\ValidatorServiceProvider());

$app->register(new Silex\Provider\SwiftmailerServiceProvider());