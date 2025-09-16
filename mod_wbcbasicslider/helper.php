<?php
defined('_JEXEC') or die;

class WbcBasicSliderHelper
{
     public static function getImages($params)
    {
        $images = $params->get('sliderimages', []);
        return is_array($images) ? $images : [];
    }

    public static function getPerSlide($params)
    {
        $perSlide = (int) $params->get('perSlide', 5);
        return max(1, $perSlide);
    }
}
