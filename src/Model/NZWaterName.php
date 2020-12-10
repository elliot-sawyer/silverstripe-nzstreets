<?php
namespace ElliotSawyer\NZStreets;

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\TextField;
class NZWaterName extends DataObject {
    private static $table_name = 'NZWaterName';

    private static $singular_name = 'Water Name';
    private static $plural_name = 'Water Names';

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
