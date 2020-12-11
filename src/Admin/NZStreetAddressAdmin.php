<?php
namespace ElliotSawyer\NZStreets;
use SilverStripe\Admin\ModelAdmin;
class NZStreetAddressAdmin extends ModelAdmin {
    private static $menu_title = 'NZ Street Addresses';
    private static $url_segment = 'nz-addresses';
    private static $managed_models = [
        NZTownCity::class,
        NZSuburbLocality::class,
        NZStreetAddress::class
    ];

    private static $model_importers = [
        NZStreetAddress::class => NZStreetAddressCSVImporter::class
    ];
}
