<?php
namespace ElliotSawyer\NZStreets;

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\TextField;
class NZWaterRouteName extends DataObject {
    private static $table_name = 'NZWaterRouteName';

    private static $singular_name = 'Water Route Name';
    private static $plural_name = 'Water Route Names';

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

    private static $has_many = [
        'Addresses' => NZStreetAddress::class
    ];

    private static $summary_fields = [
        'Title' => 'Name',
        'Addresses.Count' => 'Addresses'
    ];
}
