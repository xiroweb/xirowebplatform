<?php

defined('_JEXEC') or die;

extract($displayData);

$html = '<button type="button" data-target="#' . $selector . '" class="'. $class . '" data-toggle="modal"' . '"><i class="'. $icon . '"></i> ' . $title . '</button>';
echo $html;