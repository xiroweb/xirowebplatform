<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$form = $displayData->getForm();

// JLayout for standard handling of metadata fields in the administrator content edit screens.
$fieldSets = $form->getFieldsets('metadata');
?>
 <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo JText::_('TPL_XIROADMIN_COM_CONTENT_FIELD_GROUP_SEO'); ?></h3>
            </div>
            <div class="box-body">

<?php foreach ($fieldSets as $name => $fieldSet) : ?>

	<?php
	// Include the real fields in this panel.
	if ($name === 'jmetadata')
	{
		echo $form->renderField('metadesc');
		echo $form->renderField('metakey');
	}

 ?>
<?php endforeach; ?>

	</div>
</div>