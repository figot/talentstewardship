<?php



class HTMLPurifier_AttrTransform_ImgWidth extends HTMLPurifier_AttrTransform
{
    public function transform($attr, $config, $context) {
        if (isset($attr['class'])) {
            $attr['class'] .= ' img-responsive';
        } else {
            $attr["class"] = "img-responsive";
        }
        return $attr;
    }
}