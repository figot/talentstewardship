<?php



class HTMLPurifier_AttrTransform_SpanAttr extends HTMLPurifier_AttrTransform
{
    public function transform($attr, $config, $context) {
        if (isset($attr['class'])) {
            $attr['class'] .= ' customtext';
        } else {
            $attr["class"] = "customtext";
        }
        return $attr;
    }
}