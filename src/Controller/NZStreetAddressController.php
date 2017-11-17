<?php
namespace ElliotSawyer\NZStreets;

use SilverStripe\Control\Controller;
use SilverStripe\Core\Convert;
use ElliotSawyer\NZStreets\NZStreetAddress;

class NZStreetAddressController extends Controller {
    //required by SilverStripe 4 when using a "bare" controller
    private static $url_segment = 'address';

    //designate some actions that this controller will respond to
    private static $allowed_actions = [
        'search',
        'details',
    ];

    //content type that this will respond to. Only application/json is supported at this point.
    private static $content_type = 'application/json';

    //default limit of search results.
    private static $search_limit = 10;

    //set content type
    public function init() {
        parent::init();
        $this->request->addHeader('Content-Type', $this->config()->content_type);
    }

    /**
     * Search for a full address that "starts with" a particular query
     * For example, `101-103` might return `101-103 Courtenay Place, Te Aro, Wellington`
     * @param $request containing a GET parameter "q"
     * @return string json_encoded array of results
     */
    public function search($request) {
        $query = Convert::raw2sql($request->getVar('q'));
        $limit = $this->config()->search_limit;
        $addresses = NZStreetAddress::get()->filter('FullAddress:StartsWith', $query)
            ->limit($limit);
        $output = [];
        foreach($addresses as $address) {
            $output[] = [
                'AddressID' => $address->AddressID,
                'FullAddress' => $address->FullAddress,
                'AddressLine1' => sprintf("%s %s",
                    $address->FullAddressNumber,
                    $address->FullRoadName
                ),
                'Suburb' => $address->SuburbLocality,
                'City' => $address->TownCity
            ];
        }

        return json_encode($output);
    }

    /**
     * Obtain the full record for a particular address
     * @param $request containing a GET parameter "AddressID", obtained from Search method
     * @return string single json_encoded record
     */
    public function details($request) {
        $query = Convert::raw2sql($request->getVar('AddressID'));
        if(!$query) return "{}";

        $address = NZStreetAddress::get()->find('AddressID', $query);
        if($address && $address->ID) {
            $map = $address->toMap();
            unset($map['ID']);
            unset($map['ClassName']);
            unset($map['RecordClassName']);
            unset($map['RecordClassName']);
            return json_encode($map);
        }

        return "{}";
    }
}
