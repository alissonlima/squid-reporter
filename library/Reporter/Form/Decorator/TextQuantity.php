<?php

class Reporter_Form_Decorator_TextQuantity extends Zend_Form_Decorator_Abstract
{
    protected $_format = '<input class="form_input" id="%s" name="%s" type="text" value="%s" size="4"/> <label for="%s">%s</label><br/>';

    public function render($content)
    {
        $element = $this->getElement();
        $name    = $element->getFullyQualifiedName();
        $label   = $element->getLabel();
        $id      = $element->getId();
        $value   = $element->getValue();

        $markup  = sprintf($this->_format, $id, $name, $value, $id, $label);
        return $markup;
    }
}

