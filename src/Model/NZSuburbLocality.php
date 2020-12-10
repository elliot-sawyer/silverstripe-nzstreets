<?php
namespace ElliotSawyer\NZStreets;

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\TextField;
class NZSuburbLocality extends DataObject {
    private static $table_name = 'NZSuburbLocality';

    private static $singular_name = 'Suburb/Locality';
    private static $plural_name = 'Suburbs/Localities';
    private static $default_sort = 'Title ASC';

    private static $db = [
        'Title' => 'Varchar(255)',
        'Num' => 'Int'
    ];

    private static $many_many = [
        'Streets' => NZFullRoadName::class
    ];

    private static $belongs_many_many = [
        'TownCity' => NZTownCity::class
    ];

    private static $indexes = [
        'TitleIndex' => [
            'type' => 'index',
            'columns' => ["Title"]
        ],
    ];

    private static $summary_fields = [
        'Title' => 'Name',
    ];
}
