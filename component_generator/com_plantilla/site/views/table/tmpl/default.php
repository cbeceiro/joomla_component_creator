<?php
/**
 * @version     1.0.0
 * @package     com_gp
 * @copyright   Copyright (C) 2014. Todos los derechos reservados.
 * @license     Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 * @author      Guía Peñin <guiapenin@guiapenin.com> - http://
 */
// no direct access
defined('_JEXEC') or die;

//Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_[com]', JPATH_ADMINISTRATOR);

?>
<?php if ($this->item) : ?>

    <div class="item_fields">

        <ul class="fields_list">

            [CAMPOS]


        </ul>

    </div>
    
<?php
else:
    echo JText::_('COM_[comu]_ITEM_NOT_LOADED');
endif;
?>
