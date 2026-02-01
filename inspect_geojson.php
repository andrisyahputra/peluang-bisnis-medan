<?php
$json = file_get_contents('Provinsi Sumatera Utara-KECAMATAN.geojson');
$data = json_decode($json, true);

foreach ($data['features'] as $feature) {
    if (strpos(json_encode($feature['properties']), 'Medan') !== false) {
        print_r($feature['properties']);
        break;
    }
}
