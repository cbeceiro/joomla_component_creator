<?php
/**
 * @version     1.0.0
 * @package     com_[com]
 * @copyright   Copyright (C) 2014. Todos los derechos reservados.
 * @license     Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 * @author      Guía Peñin <guiapenin@guiapenin.com> - http://
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * [table] controller class.
 */
class [comUC]Controller[tableU] extends JControllerForm
{

    function __construct() {
        $this->view_list = '[tables]';
        parent::__construct();
    }

}