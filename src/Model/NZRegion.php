<?php
namespace ElliotSawyer\NZStreets;
use SilverStripe\ORM\DataObject;

/**
 * A classic hierarchy of New Zealand's regions from north-to-south
 * This is defined by TradeMe who have organise NZ place names according to
 * Region / District / Suburbs
 */
class NZRegion extends DataObject
{
    private static $table_name = 'NZRegion';
    private static $singular_name = 'Region';
    private static $plural_name = 'Regions';

    private static $db = [
        'Title' => 'Varchar(20)'
    ];

    private static $has_many = [
        'Cities' => NZTownCity::class
    ];
}
