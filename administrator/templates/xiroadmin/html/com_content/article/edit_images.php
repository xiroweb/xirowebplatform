<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$groupImages =  $this->form->getGroup('images');
$groupImages['jform_images_image_intro']->preview = 'show';
$groupImages['jform_images_image_fulltext']->preview = 'show';

$modal_image_intro_attribute = JHtml::_(
    'bootstrap.renderModal',
    'ModalSelectImageIntro',
    array(
        'title'       => JText::_('TPL_XIROADMIN_COM_CONTENT_FIELD_IMAGE_INTRO_OPTIONS_MODAL_TITLE'),
        'height'      => '400px',
        'width'       => '200px',
        'bodyHeight'  => '70',
        'modalWidth'  => '30',
        'footer'      => '<a role="button" class="btn" data-dismiss="modal" aria-hidden="true">' . JText::_('JLIB_HTML_BEHAVIOR_CLOSE') . '</a>',
    ),
    $groupImages['jform_images_image_intro_alt']->renderField() . $groupImages['jform_images_image_intro_caption']->renderField()
);
$button_image_intro_attribute = '<button'
. ' class=" btn edit_attribute"'
. ' data-toggle="modal"'
. ' role="button"'
. ' href="#ModalSelectImageIntro' . '"'
. '">'
. '<span class="icon-edit" aria-hidden="true"></span> '
. '</button>';

$modal_image_fulltext_attribute = JHtml::_(
    'bootstrap.renderModal',
    'ModalSelectImageIntro',
    array(
        'title'       => JText::_('TPL_XIROADMIN_COM_CONTENT_FIELD_IMAGE_FULTEXT_OPTIONS_MODAL_TITLE'),
        'height'      => '400px',
        'width'       => '200px',
        'bodyHeight'  => '70',
        'modalWidth'  => '30',
        'footer'      => '<a role="button" class="btn" data-dismiss="modal" aria-hidden="true">' . JText::_('JLIB_HTML_BEHAVIOR_CLOSE') . '</a>',
    ),
    $groupImages['jform_images_image_fulltext_alt']->renderField() . $groupImages['jform_images_image_fulltext_caption']->renderField()
);
$button_image_fultext_attribute = '<button'
. ' class=" btn edit_attribute"'
. ' data-toggle="modal"'
. ' role="button"'
. ' href="#ModalSelectImageIntro' . '"'
. '">'
. '<span class="icon-edit" aria-hidden="true"></span> ' 
. '</button>';
?>
<div class="row-bs3 form-vertical">
    <div class="col-xs-6">
        <div class="image-media-select">
            <?php
            echo $groupImages['jform_images_image_intro']->renderField(array('preview' => true));
            echo $button_image_intro_attribute;
            echo $modal_image_intro_attribute; 
            ?>
        </div>
    </div>
    <div class="col-xs-6">
        <div class="image-media-select"> 
            <?php 
                echo $groupImages['jform_images_image_fulltext']->renderField();
                echo $button_image_fultext_attribute;
                echo $modal_image_fulltext_attribute; 
                ?>
        </div>
    </div>
</div>