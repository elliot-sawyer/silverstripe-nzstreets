<?php
namespace ElliotSawyer\NZStreets;

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\TextField;
class NZTownCity extends DataObject {
    private static $table_name = 'NZTownCity';

    private static $singular_name = 'Town/City';
    private static $plural_name = 'Towns/Cities';
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
        'Suburbs' => NZSuburbLocality::class
    ];

    private static $summary_fields = [
        'Title' => 'Name',
        // 'Addresses.Count' => 'Addresses'
    ];
}
