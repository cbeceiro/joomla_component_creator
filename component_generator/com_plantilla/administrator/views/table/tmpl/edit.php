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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_[com]/assets/css/[com].css');
?>
<script type="text/javascript">
    js = jQuery.noConflict();
    js(document).ready(function(){
        
    });
    
    Joomla.submitbutton = function(task)
    {
        if(task == '[table].cancel'){
            Joomla.submitform(task, document.getElementById('[table]-form'));
        }
        else{
            
            if (task != '[table].cancel' && document.formvalidator.isValid(document.id('[table]-form'))) {
                
                Joomla.submitform(task, document.getElementById('[table]-form'));
            }
            else {
                alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
            }
        }
    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_[com]&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="[table]-form" class="form-validate">
    <div class="row-fluid">
        <div class="span10 form-horizontal">
            <fieldset class="adminform">

            [camposform]


            </fieldset>
        </div>

        

        <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>

    </div>
</form>