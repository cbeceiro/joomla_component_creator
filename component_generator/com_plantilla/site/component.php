<?php
/**
 * @version     1.0.0
 * @package     com_gp
 * @copyright   Copyright (C) 2014. Todos los derechos reservados.
 * @license     Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 * @author      Guía Peñin <guiapenin@guiapenin.com> - http://
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

// Execute the task.
$controller	= JControllerLegacy::getInstance('[comUC]');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
