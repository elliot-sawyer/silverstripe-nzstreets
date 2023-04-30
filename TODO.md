# TODO

The original LINZ dataset has been deprecated and this module will support its replacement.  The deprecated version is expected to be unavailable from June 2023.

## Changes to dataset

The data appears to remain the same, with some additional columns added to it. There are no guarantees old records in the original set, will appear in the new one. 

OLD source: https://data.linz.govt.nz/layer/53353-nz-street-address-deprecated/data/
NEW source: https://data.linz.govt.nz/layer/105689-nz-addresses/

OLD headers:
WKT,address_id,change_id,address_type,unit_value,address_number,address_number_suffix,address_number_high,water_route_name,water_name,suburb_locality,town_city,full_address_number,full_road_name,full_address,road_section_id,gd2000_xcoord,gd2000_ycoord,water_route_name_ascii,water_name_ascii,suburb_locality_ascii,town_city_ascii,full_road_name_ascii,full_address_ascii,shape_X,shape_Y

NEW headers:
WKT,address_id,source_dataset,change_id,full_address_number,full_road_name,full_address,territorial_authority,unit_type,unit_value,level_type,level_value,address_number_prefix,address_number,address_number_suffix,address_number_high,road_name_prefix,road_name,road_type_name,road_suffix,water_name,water_body_name,suburb_locality,town_city,address_class,address_lifecycle,gd2000_xcoord,gd2000_ycoord,road_name_ascii,water_name_ascii,water_body_name_ascii,suburb_locality_ascii,town_city_ascii,full_road_name_ascii,full_address_ascii,shape_X,shape_Y


## v2.0: Changes to the module to support new dataset:

* Support Silverstripe 5, the module _may_ work in 4 but I won't officially support it
* namespace has changed from ElliotSawyer to Cashware (this is an NZ business entity). Module remains opensource and free to use, though you might want to consider a donation!  Paid support is also available. 
* sideloading doesn't work OOB in MySQL 8 and you need to do some stuff to enable it: https://stackoverflow.com/questions/59993844/error-loading-local-data-is-disabled-this-must-be-enabled-on-both-the-client
    - inside MySQL server as root: `SET GLOBAL local_infile=1;`
    - when connecting with client as root: mysql --local-infile=1 -u root -p
    - even so, 2180468 records loaded in less than 10 minutes on a laptop with 32GB of memory
    - you could import using a tool like Adminer or PMA, but it will take a very long time
* data type changed for Latitude/Longitude and ShapeX/ShapeY have changed from Float to Double(2|3, 8|13). The original default Float type truncated the points to 4 decimal places, which is around 11 meters in meatspace. While fine for address lookups, this makes the module rather poor for geospatial applications.  The full value is present in the source, so it is captured in full
* new tables in mysql to break the set up into smaller searchable (and easily indexed) parts
* controller is a bit smarter
* (maybe) can redis help with lookups

"POINT (172.682427990989 -43.5691006197534)",3008605,CADS,8605,LEVEL 1 301,Port Hills Road,"LEVEL 1 301 Port Hills Road, Hillsborough, Christchurch",Christchurch City,,,LEVEL,1,,301,,,,Port Hills,Road,,,,Hillsborough,Christchurch,Thoroughfare,Current,172.68242799,-43.56910062,Port Hills,,,Hillsborough,Christchurch,Port Hills Road,"LEVEL 1 301 Port Hills Road, Hillsborough, Christchurch",172.682427990989,-43.5691006197534




SELECT AddressType, COUNT(AddressType) as C FROM NZStreetAddress GROUP BY AddressType ORDER BY C DESC;
SELECT WaterRouteName, COUNT(WaterRouteName) as C FROM NZStreetAddress GROUP BY WaterRouteName ORDER BY C DESC;
SELECT WaterName, COUNT(WaterName) as C FROM NZStreetAddress GROUP BY WaterName ORDER BY C DESC;
SELECT FullAddress, COUNT(FullAddress) as C FROM NZStreetAddress GROUP BY FullAddress ORDER BY C DESC;
SELECT RoadSectionID, COUNT(RoadSectionID) as C FROM NZStreetAddress GROUP BY RoadSectionID ORDER BY C DESC;
SELECT Longitude, COUNT(Longitude) as C FROM NZStreetAddress GROUP BY Longitude ORDER BY C DESC;
SELECT Latitude, COUNT(Latitude) as C FROM NZStreetAddress GROUP BY Latitude ORDER BY C DESC;
SELECT ShapeX, COUNT(ShapeX) as C FROM NZStreetAddress GROUP BY ShapeX ORDER BY C DESC;
SELECT ShapeY, COUNT(ShapeY) as C FROM NZStreetAddress GROUP BY ShapeY ORDER BY C DESC;


SELECT UnitValue, COUNT(UnitValue) as C FROM NZStreetAddress GROUP BY UnitValue ORDER BY C DESC;
SELECT AddressNumber, COUNT(AddressNumber) as C FROM NZStreetAddress GROUP BY AddressNumber ORDER BY C DESC;
SELECT AddressNumberSuffix, COUNT(AddressNumberSuffix) as C FROM NZStreetAddress GROUP BY AddressNumberSuffix ORDER BY C DESC;
SELECT AddressNumberHigh, COUNT(AddressNumberHigh) as C FROM NZStreetAddress GROUP BY AddressNumberHigh ORDER BY C DESC;


SELECT SuburbLocality, COUNT(SuburbLocality) as C FROM NZStreetAddress GROUP BY SuburbLocality ORDER BY C DESC;
SELECT TownCity, COUNT(TownCity) as C FROM NZStreetAddress GROUP BY TownCity ORDER BY C DESC;
SELECT FullAddressNumber, COUNT(FullAddressNumber) as C FROM NZStreetAddress GROUP BY FullAddressNumber ORDER BY C DESC;
SELECT FullRoadName, COUNT(FullRoadName) as C FROM NZStreetAddress GROUP BY FullRoadName ORDER BY C DESC;


#SELECT TownCity, SuburbLocality FROM NZStreetAddress WHERE TownCity != "" AND SuburbLocality != "" GROUP BY TownCity, SuburbLocality ORDER BY TownCity ASC, SuburbLocality ASC;

INSERT INTO TownCity (Name, Hits)
	SELECT TownCity AS Name, COUNT(TownCity) AS Hits FROM NZStreetAddress WHERE TownCity != "" GROUP BY TownCity ORDER BY TownCity ASC
SELECT District.Title, TownCity.ID FROM District, TownCity WHERE District.TownCityID = 0 AND District.Title = TownCity.Name;

INSERT INTO SuburbLocality (Name, Hits)
	SELECT SuburbLocality AS Name, COUNT(SuburbLocality) AS Hits FROM NZStreetAddress WHERE SuburbLocality != "" GROUP BY SuburbLocality ORDER BY SuburbLocality ASC

SELECT City.Title, SuburbLocality.ID FROM City, SuburbLocality WHERE City.SuburbLocalityID = 0 AND City.Title = SuburbLocality.Name;
