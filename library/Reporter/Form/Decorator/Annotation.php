<?php

class Reporter_Form_Decorator_Annotation extends Zend_Form_Decorator_Abstract
{
    protected $_format = '%s';

    public function render($content)
    {
        $element = $this->getElement();
        $name    = htmlentities($element->getFullyQualifiedName());
        #$label   = htmlentities($element->getLabel());
        $label   = $element->getLabel();
        $id      = htmlentities($element->getId());
        $value   = htmlentities($element->getValue());

        $markup  = sprintf($this->_format, $label);
        return $markup;
    }
}

