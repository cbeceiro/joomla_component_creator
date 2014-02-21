<?php
/**
 * @version     1.0.0
 * @package     com_gp
 * @copyright   Copyright (C) 2014. Todos los derechos reservados.
 * @license     Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 * @author      Guía Peñin <guiapenin@guiapenin.com> - http://
 */

// No direct access.
defined('_JEXEC') or die;

require_once JPATH_COMPONENT.'/controller.php';

/**
 * Wines list controller class.
 */
class [comUC]Controller[tableUs] extends [comUC]Controller
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function &getModel($name = '[tableUs]', $prefix = '[comUC]Model')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
}