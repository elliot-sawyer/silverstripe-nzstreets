<?php

use ElliotSawyer\NZStreets\NZRegion;
use ElliotSawyer\NZStreets\NZSuburbLocality;
use ElliotSawyer\NZStreets\NZTownCity;
use GuzzleHttp\Client;
use SilverStripe\Core\Convert;
use SilverStripe\Dev\BuildTask;
use SilverStripe\ORM\DB;

class GenerateRegions extends BuildTask
{
    private static $trademe_api_localities = 'https://api.trademe.co.nz/v1/Localities.json';

    public function run($request)
    {

        $client = new Client();
        $response = $client->request('GET', $this->config()->trademe_api_localities);

        if($response && $body = (string) $response->getBody()) {
            $regions = json_decode($body);
            foreach($regions as $region) {
                if($region->Name == 'All') continue;

                $regionName = Convert::raw2sql($region->Name);
                $nzregion = NZRegion::get()->find('Title', $regionName)
                    ?: NZRegion::create();

                if(!($nzregion && $nzregion->ID)) {
                    $nzregion->Title = $regionName;
                    $nzregion->write();
                }


                DB::alteration_message($nzregion->Title);
                if(!($region && $region->Districts)) continue;

                foreach($region->Districts as $district) {
                    $regionID = (int) $nzregion->ID;
                    $townCityName = Convert::raw2sql($district->Name);
                    DB::alteration_message("\t - ".$townCityName);

                    $townCity = NZTownCity::get()->find('Title', $townCityName);
                    $townCityID = 0;
                    if ($townCity && $townCity->ID) {
                        $townCity->RegionID = $regionID;
                        $townCity->write();
                        $townCityID = $townCity->ID;
                    }
                    if(!($district && $district->Suburbs)) continue;

                    foreach($district->Suburbs as $suburb) {
                        if($townCityID) {
                            $suburbName = Convert::raw2sql($suburb->Name);
                            DB::alteration_message("\t\t - ".$suburbName);

                            //this is a suburb that's part of a larger town or city
                            $suburb = NZSuburbLocality::get()->find('Title', $suburbName);
                            if($suburb && $suburb->ID) {
                                $suburb->TownCityID = $townCityID;
                                $suburb->write();
                            }
                        } else {
                            $townCityName = Convert::raw2sql($suburb->Name);
                            DB::alteration_message("\t\t - ".$townCityName);

                            //this is a standalone town, not a suburb of a larger city
                            $townCity = NZTownCity::get()->find('Title', $townCityName);
                            if($townCity && $townCity->ID) {
                                $townCity->RegionID = $regionID;
                                $townCity->write();
                            }
                        }
                    }
                }
            }
        }
    }

}
