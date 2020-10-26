<?php
/**
 * @package     XiroWeb.Xiroadmin
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2020 XiroWeb, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; 
 */

defined('_JEXEC') or die;

$template = $displayData['template'];
$clientId = $displayData['client_id'];

$client = JApplicationHelper::getClientInfo($clientId);
$basePath = $client->path . '/templates/' . $template;
$thumb = $basePath . '/template_thumbnail.png';
$preview = $basePath . '/template_preview.png';
$html = '';

if (file_exists($thumb))
{

    $clientPath = ($clientId == 0) ? '' : 'administrator/';
    $thumb = $clientPath . 'templates/' . $template . '/template_thumbnail.png';
    $html = JHtml::_('image', $thumb, JText::_('COM_TEMPLATES_PREVIEW'), array('class' => 'card-img-top'));

    if (file_exists($preview))
    {
        $preview = $clientPath . 'templates/' . $template . '/template_preview.png';
        $html = JHtml::_('image', $preview , JText::_('COM_TEMPLATES_PREVIEW'), array('class' => 'card-img-top'));
    }
}

echo $html;