<?php
namespace ElliotSawyer\NZStreets;

use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordViewer;
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

    private static $has_one = [
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

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab(
            'Root.Addresses',
            GridField::create(
                'Addresses',
                'Addresses',
                $this->getAddresses(),
                GridFieldConfig_RecordViewer::create()
            )
        );
        return $fields;
    }

    public function getAddresses()
    {
        return NZStreetAddress::get()->filter([
            'CityID' => $this->TownCityID,
            'SuburbID' => $this->ID
        ]);
    }
}
