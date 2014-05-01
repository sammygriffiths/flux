<?php

define(APP_DIR, __DIR__.'/../app/');

require_once __DIR__.'/../vendor/autoload.php';
require_once APP_DIR.'bootstrap.php';
require_once APP_DIR.'bin/functions.php';

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

$app->get('/', function () use ($app, $modules) {
	return $app['twig']->render('index.html.twig', array(
		'title' => 'Page Title',
		'meta' => array('title' => 'Page Title'),
		'modules' => $modules,
		'pages' => $pages,
	));
});

$app->match('/contact', function (Request $request) use ($app) {
	
	$data = array(
		'name',
		'email',
		'number',
		'enquiry',
	);

	$form = $app['form.factory']->createBuilder('form', $data)
		->add('name', 'text', array(
			'constraints' => array(
				new Symfony\Component\Validator\Constraints\NotBlank()
			),
		))
		->add('email', 'text', array(
			'constraints' => array(
				new Symfony\Component\Validator\Constraints\Email(),
				new Symfony\Component\Validator\Constraints\NotBlank(),
			),
		))
		->add('number', 'text', array(
			'constraints' => array(
				new Symfony\Component\Validator\Constraints\NotBlank()
			),
		))
		->add('enquiry', 'textarea', array(
			'constraints' => array(
				new Symfony\Component\Validator\Constraints\NotBlank()
			),
		))
		->getForm();

	$form->handleRequest($request);

	if($form->isValid())
	{
		$data = $form->getData();

		$body = "A message has been received from the contact form of WEBSITE:\n\n";
		$body .= "From: {$data['name']} - {$data['email']}\n";
		$body .= "Number: {$data['number']}\n";
		$body .= "Enquiry: ".wordwrap($data['enquiry'], 70);

		$app['swiftmailer.options'] = array(
			'host' => '',
			'port' => '',
			'username' => '',
			'password' => '',
			'encryption' => null,
			'auth_mode' => null
		);

		$message = \Swift_Message::newInstance()
			->setSubject('Website Enquiry')
			->setFrom(array('no-reply@website' => 'Website Contact Form'))
			->setTo(array(''))
			->setBody($body);

		$app['mailer']->send($message);
		
		return $app->redirect('/contact-success');	
	}

	return $app['twig']->render('contact.html.twig', array(
		'form' => $form->createView()
	));
})
->method('GET|POST');

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

$app->run();