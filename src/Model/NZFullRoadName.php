<?php
namespace ElliotSawyer\NZStreets;

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\TextField;
class NZFullRoadName extends DataObject {
    private static $table_name = 'NZFullRoadName';

    private static $singular_name = 'Road Name';
    private static $plural_name = 'Road Names';
    private static $default_sort = 'Title ASC';

    private static $indexes = [
        'TitleIndex' => [
            'type' => 'index',
            'columns' => ["Title"]
        ],
    ];

    private static $db = [
        'Title' => 'Varchar(255)',
        'Num' => 'Int'
    ];

    private static $many_many = [
        'Addresses' => NZStreetAddress::class
    ];

    private static $belongs_many_many = [
        'SuburbLocality' => NZSuburbLocality::class
    ];

    private static $summary_fields = [
        'Title' => 'Name',
        'Addresses.Count' => 'Addresses'
    ];
}
