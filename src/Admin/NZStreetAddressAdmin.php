<?php
class NZStreetAddressAdmin extends ModelAdmin {
    private static $menu_title = 'NZ Street Addresses';
    private static $url_segment = 'nz-addresses';
    private static $managed_models = [
        'NZStreetAddress'
    ];

    private static $model_importers = [
        'NZStreetAddress' => 'NZStreetAddressCSVImporter'
    ];
}