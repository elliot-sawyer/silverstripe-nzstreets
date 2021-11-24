NZ Street Address module for SilverStripe
=========================================

Address lookup using LINZ Address Data.

Use the 0.0.x tags for SilverStripe 3 installations.  SilverStripe 4 support will be handled from versions 0.1.x.

Installation
------------
Add the repository to your composer.json file
```
    "repositories": [
        {
            "type": "vcs",
            "url": "git@github.com:elliot-sawyer/silverstripe-nzstreets.git"
        }
    ]
```

Add the project to the require section of composer.json
```
    "require": {
    ...
        "elliot-sawyer/nzstreets": "^0.1"
    ... 
```

Setup
------
Composer should place the repository in your webroot.

Create a new route in routes.yml. You can change `address` to any url_segment that meets your needs
```
SilverStripe\Control\Director:
  rules:
    'address//$Action/$ID/$Name': 'ElliotSawyer\NZStreets\NZStreetAddressController' 
```

Download the CSV data source from https://data.linz.govt.nz/layer/3353-nz-street-address/data/
                                             
This is a massive file (500+ MB once extracted) and contains over 1.9 million records. The supplied importer will work but it's very slow: you should only use it for a smaller subset of files, or as a last resort for the entire set. For the fastest results, sideload it using mysqladmin or a similar database tool.

Usage
-----
This module was created to feed into an autosuggest address lookup and is suitable for that purpose.

You can now search for addresses that start with your query. For example:  
* https://yoursite/address/search?q=101-103
* https://yoursite/address/search?q=2/133
* https://yoursite/address/search?q=14+L

The default limit is 10 results. You can override this in your config.yml:
```
ElliotSawyer\NZStreets\NZStreetAddressController:
  search_limit: 5 
```

Each search result contains an AddressID. For more details about an address, you can query by that ID:
* http://yoursite/address/details?AddressID=1579100

Sideloading
-----------

Build the table using the dev/build command. You can sideload the CSV file into MySQL with the following query:
```sql
LOAD DATA LOCAL INFILE '/path/to/your/nz-street-address.csv'
INTO TABLE NZStreetAddress
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"' 
LINES TERMINATED BY '\r\n'
IGNORE 1 LINES
(WKT,AddressID,ChangeID,AddressType,UnitValue,AddressNumber,AddressNumberSuffix,AddressNumberHigh,WaterRouteName,WaterName,SuburbLocality,TownCity,FullAddressNumber,FullRoadName,FullAddress,RoadSectionID,Longitude,Latitude,@dummy,@dummy,@dummy,@dummy,@dummy,@dummy,ShapeX,ShapeY)
SET ClassName="ElliotSawyer\\NZStreets\\NZStreetAddress", LastEdited=NOW(), Created=NOW();
```

Contributing
------------

Contributions are more than welcome! Please raise some issues or create pull requests on the Github repo.

Support
--------
Need some extra help or just love my work? Consider shouting me a coffee or a small donation if this module helped you solve a problem. I accept cryptocurrency at the following addresses:
* Bitcoin: 12gSxkqVNr9QMLQMMJdWemBaRRNPghmS3p
* Bitcoin Cash: 1QETPtssFRM981TGjVg74uUX8kShcA44ni
* Litecoin: LbyhaTESx3uQvwwd9So4sGSpi4tTJLKBdz
* Ethereum: 0x0694E0704c70D8d178dd2e9522FC59EBBEe86748
