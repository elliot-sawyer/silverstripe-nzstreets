<?php
namespace ElliotSawyer\NZStreets;

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\TextField;
class NZStreetAddress extends DataObject {
    private static $table_name = 'NZStreetAddress';

    private static $singular_name = 'NZ Street Address';
    private static $plural_name = 'NZ Street Addresses';

    //column lengths were determined by importing the entire set and finding the longest column
    // select max(length(COLUMNNAME)) from NZStreetAddress
    private static $db = [
        'AddressID' => 'Int',
        'AddressType' => 'Enum("Water,Road", "Road)',
        'UnitValue' => 'Varchar(5)',
        'AddressNumber' => 'Varchar(5)',
        'AddressNumberSuffix' => 'Varchar(3)',
        'AddressNumberHigh' => 'Varchar(4)',
        'SuburbLocality' => 'Varchar(35)',
        'TownCity' => 'Varchar(25)',
        'FullAddressNumber' => 'Varchar(18)',
        'FullRoadName' => 'Varchar(33)',
        'FullAddress' => 'Varchar(80)',
        'Longitude' => 'Float',
        'Latitude' => 'Float',
        'ShapeX' => 'Float',
        'ShapeY' => 'Float',
        'WKT' => 'Varchar(55)',
        'ChangeID' => 'Int',
        'WaterRouteName' => 'Varchar(19)',
        'WaterName' => 'Varchar(30)',
        'RoadSectionID' => 'Int',
    ];

    private static $summary_fields = [
        'FullAddress' => 'Full address',
        'Latitude' => 'Latitude',
        'Longitude' => 'Longitude'
    ];

    // @todo: intent is to optimise searching by address
    // limiting searches from the first character should speed this up.
    private static $searchable_fields = [
       'FullAddress' => [
          'field' => TextField::class,
          'filter' => 'StartsWithFilter'
       ]
    ];

    private static $indexes = [
        'FullAddressIndex' => [
            'type' => 'index',
            'columns' => ["FullAddress"]
        ],
        // @todo: reverse geocoding, resolve coordinate to an address
        'LatitudeIndex' => [
            'type' => 'index',
            'columns' => ["Latitude"]
        ],
        'LongitudeIndex' => [
            'type' => 'index',
            'columns' => ["Longitude"]
        ],
        'AddressID' => [
            'type' => 'index',
            'columns' => ["AddressID"]
        ],
    ];

}
