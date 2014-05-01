<?php

/**
 * @return boolean
 */
function verifyPageTemplateExists($page = null)
{
	if(null === $page)
	{
		return false;
	}

	$template = APP_DIR.'views/pages/'.$page.'.html.twig';

	return verifyTemplateIsFile($template);	
}

/**
 * @return boolean
 */
function verifyModuleTemplateExists($module = null, $page = null)
{
	if(null === ($module||$page))
	{
		return false;
	}

	$template = APP_DIR.'views/'.$module.'/'.$page.'.html.twig';
	
	return verifyTemplateIsFile($template);	
}

/**
 * @return boolean
 */
function verifyTemplateIsFile($template)
{
	$file = new \SplFileInfo($template);
	
	return $file->isFile();
}