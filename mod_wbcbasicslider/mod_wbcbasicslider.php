<?php
use Joomla\CMS\Helper\ModuleHelper;

defined('_JEXEC') or die;

require_once __DIR__ . '/helper.php';

require ModuleHelper::getLayoutPath('mod_wbcbasicslider', $params->get('layout', 'default'));