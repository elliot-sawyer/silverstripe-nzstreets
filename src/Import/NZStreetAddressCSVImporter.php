<?php
class NZStreetAddressCSVImporter extends CsvBulkLoader {
    public function __construct($objectClass) {
        //@todo: should just remove the limit entirely
        ini_set('memory_limit', '2G');
        parent::__construct($objectClass);
    }
    public $columnMap = [
        'WKT' => 'WKT',
        'address_id' => 'AddressID',
        'change_id' => 'ChangeID',
        'address_type' => 'AddressType',
        'unit_value' => 'UnitValue',
        'address_number' => 'AddressNumber',
        'address_number_suffix' => 'AddressNumberSuffix',
        'address_number_high' => 'AddressNumberHigh',
        'water_route_name' => 'WaterRouteName',
        'water_name' => 'WaterName',
        'suburb_locality' => 'SuburbLocality',
        'town_city' => 'TownCity',
        'full_address_number' => 'FullAddressNumber',
        'full_road_name' => 'FullRoadName',
        'full_address' => 'FullAddress',
        'road_section_id' => 'RoadSectionID',
        'gd2000_xcoord' => 'Longitude',
        'gd2000_ycoord' => 'Latitude',
        'water_route_name_ascii' => 'WaterRouteNameAscii',
        'water_name_ascii' => 'WaterNameAscii',
        'suburb_locality_ascii' => 'SuburbLocalityAscii',
        'town_city_ascii' => 'TownCityAscii',
        'full_road_name_ascii' => 'FullRoadNameAscii',
        'full_address_ascii' => 'FullAddressAscii',
        'shape_X' => 'ShapeX',
        'shape_Y' => 'ShapeY',
   ];

    public $duplicateChecks = array(
        'address_id' => 'AddressID'
   );
}