<?php

namespace common\widgets\openstreetmap;

use yii\bootstrap4\Widget;

/**
 * Class OpenStreetMap
 *
 * @package common\widgets\openstreetmap
 */
class OpenStreetMap extends Widget
{

    public function init()
    {
        parent::init();
    }

    /**
     * @return string
     */
    public function run()
    {
        return $this->render('map');
    }
}
