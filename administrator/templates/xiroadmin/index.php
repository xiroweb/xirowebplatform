<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Templates.isis
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @since       3.0
 */

defined('_JEXEC') or die;

/** @var JDocumentHtml $this */

$app   = JFactory::getApplication();
$lang  = JFactory::getLanguage();
$input = $app->input;
$user  = JFactory::getUser();

// Output as HTML5
$this->setHtml5(true);

// Gets the FrontEnd Main page Uri
$frontEndUri = JUri::getInstance(JUri::root());
$frontEndUri->setScheme(((int) $app->get('force_ssl', 0) === 2) ? 'https' : 'http');
$mainPageUri = $frontEndUri->toString();

// Add JavaScript Frameworks
JHtml::_('bootstrap.framework');

// Add filter polyfill for IE8
JHtml::_('behavior.polyfill', array('filter'), 'lte IE 9');

// Add template js
JHtml::_('script', 'template.js', array('version' => 'auto', 'relative' => true));

// Add html5 shiv
JHtml::_('script', 'jui/html5.js', array('version' => 'auto', 'relative' => true, 'conditional' => 'lt IE 9'));

// Add Stylesheets
JHtml::_('stylesheet', 'template' . ($this->direction === 'rtl' ? '-rtl' : '') . '.css', array('version' => 'auto', 'relative' => true));

// Load specific language related CSS
JHtml::_('stylesheet', 'administrator/language/' . $lang->getTag() . '/' . $lang->getTag() . '.css', array('version' => 'auto'));

// Load custom.css
JHtml::_('stylesheet', 'custom.css', array('version' => 'auto', 'relative' => true));

JHtml::_('stylesheet', 'responsive.css', array('version' => 'auto', 'relative' => true));


JHtml::_('stylesheet', 'fontawesome.css', array('version' => 'auto', 'relative' => true));

JHtml::_('script', 'adminlte.js', array('version' => 'auto', 'relative' => true));
JHtml::_('script', 'xiroadmin.js', array('version' => 'auto', 'relative' => true));

JHtml::_('stylesheet', 'bs3-grid.css', array('version' => 'auto', 'relative' => true));
JHtml::_('stylesheet', '_all-skins.css', array('version' => 'auto', 'relative' => true));
JHtml::_('stylesheet', 'sidebar.css', array('version' => 'auto', 'relative' => true));
JHtml::_('stylesheet', 'xiroadmin.css', array('version' => 'auto', 'relative' => true));
JHtml::_('stylesheet', 'fix-app.css', array('version' => 'auto', 'relative' => true));



// Detecting Active Variables
$option   = $input->get('option', '');
$view     = $input->get('view', '');
$layout   = $input->get('layout', '');
$task     = $input->get('task', '');
$itemid   = $input->get('Itemid', 0, 'int');
$sitename = htmlspecialchars($app->get('sitename', ''), ENT_QUOTES, 'UTF-8');
$cpanel   = $option === 'com_cpanel';

$hidden = $app->input->get('hidemainmenu');

$showSubmenu          = false;
$this->submenumodules = JModuleHelper::getModules('submenu');

foreach ($this->submenumodules as $submenumodule)
{
	$output = JModuleHelper::renderModule($submenumodule);

	if ($output !== '')
	{
		$showSubmenu = true;
		break;
	}
}

// Template Parameters
$displayHeader = $this->params->get('displayHeader', '1');
$statusFixed   = $this->params->get('statusFixed', '1');
$stickyToolbar = $this->params->get('stickyToolbar', '1');

// Header classes
$navbar_color    = '';
$header_color    = $displayHeader && $this->params->get('headerColor') ? $this->params->get('headerColor') : '';
$navbar_is_light = $navbar_color && colorIsLight($navbar_color);
$header_is_light = $header_color && colorIsLight($header_color);

if ($displayHeader)
{
	// Logo file
	if ($this->params->get('logoFile'))
	{
		$logo = JUri::root() . htmlspecialchars($this->params->get('logoFile'), ENT_QUOTES);
	}
	else
	{
		$logo = $this->baseurl . '/templates/' . $this->template . '/images/logo' . ($header_is_light ? '-inverse' : '') . '.png';
	}
}
$iconlogo = $this->baseurl . '/templates/' . $this->template . '/images/icon-xiroweb.png';
$headerlogo = $this->baseurl . '/templates/' . $this->template . '/images/logo' . ($header_is_light ? '-inverse' : '') . '.png';

function colorIsLight($color)
{
	$r = hexdec(substr($color, 1, 2));
	$g = hexdec(substr($color, 3, 2));
	$b = hexdec(substr($color, 5, 2));

	$yiq = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;

	return $yiq >= 200;
}

// Pass some values to javascript
$offset = 20;

if ($displayHeader || !$statusFixed)
{
	$offset = 30;
}

$stickyBar = 0;

if ($stickyToolbar)
{
	$stickyBar = 'true';
}

// Template header color
if ($header_color)
{
	$this->addStyleDeclaration('
	.com_cpanel .content-wrapper .header {
		background-color: ' . $header_color . 'b3;
	}
	.admin .content-wrapper .header {
		border-color: ' . $header_color . ';
	}
	.skin-blue .main-header .logo {
		background-color: ' . $header_color . ';
	}
	');
}

// Link color
if ($this->params->get('linkColor'))
{
	$this->addStyleDeclaration('
	a,
	.j-toggle-sidebar-button {
		color: ' . $this->params->get('linkColor') . ';
	}
	');
}
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<jdoc:include type="head" />
</head>
<body class="admin <?php echo $option . ' view-' . $view . ' layout-' . $layout . ' task-' . $task . ' itemid-' . $itemid . ' hold-transition skin-blue sidebar-mini'; ?>" data-basepath="<?php echo JURI::root(true); ?>">
<div class="wrapper">
<!-- Top Navigation -->
<header class="main-header">
<a href="<?php echo JUri::base(); ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img src="<?php echo $iconlogo; ?>" class="logo-mini-img" alt="<?php echo $sitename;?>" /></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img src="<?php echo $headerlogo; ?>" class="logo-lg-img" alt="<?php echo $sitename;?>" /></span>
    </a>

</header>
<!-- Header -->
<aside class="main-sidebar">
	<section class="sidebar">
		<jdoc:include type="modules" name="xiromenu" style="no" />
		
	</section>
</aside>

<div class="content-wrapper">
<?php if ($displayHeader) : ?>
	<header class="header<?php echo $header_is_light ? ' header-inverse' : ''; ?>">

		<a href="#" class="button-pushmenu" data-toggle="push-menu" role="button">
			<i class="fa fa-bars"></i>
		</a>

		<div class="container-logo">
			<img src="<?php echo $logo; ?>" class="logo" alt="<?php echo $sitename;?>" />
		</div>
		<div class="container-title">
			<jdoc:include type="modules" name="title" />
		</div>
	</header>
<?php endif; ?>
<?php if (!$statusFixed && $this->countModules('status')) : ?>
	<!-- Begin Status Module -->
	<div id="status" class="navbar status-top hidden-phone">
		<div class="btn-toolbar">
			<jdoc:include type="modules" name="status" style="no" />
		</div>
		<div class="clearfix"></div>
	</div>
	<!-- End Status Module -->
<?php endif; ?>
<?php if (!$cpanel) : ?>
	<!-- Subheader -->
	<a class="btn btn-subhead" data-toggle="collapse" data-target=".subhead-collapse"><?php echo JText::_('TPL_XIROADMIN_TOOLBAR'); ?>
		<span class="icon-wrench"></span></a>
	<div class="subhead-collapse collapse" id="isisJsData" data-tmpl-sticky="<?php echo $stickyBar; ?>" data-tmpl-offset="<?php echo $offset; ?>">
		<div class="subhead">
			<div class="container-fluid">
				<div id="container-collapse" class="container-collapse"></div>
				<div class="row-fluid">
					<div class="span12">
						<!-- target for skip to content link -->
						<a id="skiptarget" class="element-invisible"><?php echo JText::_('TPL_XIROADMIN_SKIP_TO_MAIN_CONTENT_HERE'); ?></a>
						<jdoc:include type="modules" name="toolbar" style="no" />
					</div>
				</div>
			</div>
		</div>
	</div>
<?php else : ?>
	<div style="margin-bottom: 20px">
		<!-- target for skip to content link -->
		<a id="skiptarget" class="element-invisible"><?php echo JText::_('TPL_XIROADMIN_SKIP_TO_MAIN_CONTENT_HERE'); ?></a>
	</div>
<?php endif; ?>
<!-- container-fluid -->
<div class="container-fluid container-main">
	<section id="content">
		<!-- Begin Content -->
		<jdoc:include type="modules" name="top" style="xhtml" />
		<div class="row-fluid">
			<?php if ($showSubmenu) : ?>
			<div class="span2">
				<jdoc:include type="modules" name="submenu" style="none" />
			</div>
			<div class="span10 main-component">
				<?php else : ?>
				<div class="span12 main-component">
					<?php endif; ?>
					<jdoc:include type="message" />
					<jdoc:include type="component" />
				</div>
			</div>
			<?php if ($this->countModules('bottom')) : ?>
				<jdoc:include type="modules" name="bottom" style="xhtml" />
			<?php endif; ?>
			<!-- End Content -->
	</section>

	<?php if (!$this->countModules('status') || (!$statusFixed && $this->countModules('status'))) : ?>
		<footer class="footer">
			<p class="text-center">
				<jdoc:include type="modules" name="footer" style="no" />
				&copy; <?php echo $sitename; ?> <?php echo date('Y'); ?></p>
		</footer>
	<?php endif; ?>
</div>
<?php if ($statusFixed && $this->countModules('status')) : ?>
	<!-- Begin Status Module -->
	<div id="status" class="navbar navbar-fixed-bottom hidden-phone">
		<div class="btn-toolbar">
			<div class="btn-group pull-right">
				<p>
					<jdoc:include type="modules" name="footer" style="no" />
					&copy; <?php echo date('Y'); ?> <?php echo $sitename; ?>
				</p>

			</div>
			<jdoc:include type="modules" name="status" style="no" />
		</div>
	</div>
	<!-- End Status Module -->
<?php endif; ?>
<jdoc:include type="modules" name="debug" style="none" />
</div>
</div>
</body>
</html>
