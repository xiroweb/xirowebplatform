<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_stats_admin
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('jquery.framework');

$array_get = array('eye', 'file', 'users', 'clock');
$background = array('bg-aqua', 'bg-green', 'bg-yellow', 'bg-red');
$array_icon = array('fa-line-chart', 'fa-newspaper-o', 'fa-user', 'fa-star-o');
$lang		= array(JText::_('MOD_STATS_ARTICLES_VIEW_HITS'), JText::_('MOD_STATS_ARTICLES'), JText::_('MOD_STATS_USERS'), JText::_('MOD_STATS_TIME'));

$htmldefault = array();
$html = array();
?>
<?php foreach ($array_get as $key => $item) : 
		
			$htmldefault[$item] = '<div class="col-lg-4 col-xs-6"><div class="small-box '.$background[$key].'">';
			$htmldefault[$item] .= '<div class="inner"><h3>'. '0' .'</h3><p>'. $lang[$key] . '</p></div>';
			$htmldefault[$item] .= '<div class="icon"><i class="fa ' . $array_icon[$key] . '"></i></div>';
			$htmldefault[$item] .= '</div></div>';

		?>
	<?php endforeach; ?>

<div class="row-bs3">
	<?php foreach ($list as $item) : 
		if (in_array($item->icon,$array_get )) :
			$key = array_search($item->icon,$array_get);
			$html[$item->icon] = '<div class="col-lg-4 col-xs-6"><div class="small-box '.$background[$key].'">';
			$html[$item->icon] .= '<div class="inner"><h3>'. $item->data .'</h3><p>'. $item->title . '</p></div>';
			$html[$item->icon] .= '<div class="icon"><i class="fa ' . $array_icon[$key] . '"></i></div>';
			$html[$item->icon] .= '<a href="'. (isset($item->link) ? $item->link : '') . '" class="small-box-footer">';
			$html[$item->icon] .= (isset($item->link) ? JText::_('TPL_XIROADMIN_MOD_STAST_ADMIN_MORELINK').'<i class="fa fa fa-arrow-circle-right"></i>' : '&nbsp;');
			$html[$item->icon] .= '</a></div></div>';
		endif;
		?>

	<?php endforeach; ?>
	<?php 	
	$x = empty($html['file']);
		echo !empty($html['eye']) ? $html['eye'] : $htmldefault['eye'];
		echo !empty($html['file']) ? $html['file'] : $htmldefault['file'];
		echo !empty($html['users']) ? $html['users'] : $htmldefault['users'];
	?>
</div>
