<?php
/**
 * @var \yii\web\View $this
 */

use common\widgets\openstreetmap\OpenStreetMapAsset;

OpenStreetMapAsset::register($this);

?>

    <div id="map" class="w-100" style="height: 320px"></div>

<?php
$js = <<<JS
    map_obj = L.map('map', {attributionControl: true,scrollWheelZoom:false}).setView([10.96187,106.48110], 14);
    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map_obj);
    let marker = new L.marker([10.96187,106.48110], {draggable: false});
    map_obj.addLayer(marker);
    map_obj.addControl(new L.Control.Fullscreen());
JS;
$this->registerJs($js);
