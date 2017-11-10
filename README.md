NZ Street Address module for SilverStripe
=========================================

Address lookup using LIMS Address Data.

Download the CSV data source from https://data.linz.govt.nz/layer/3353-nz-street-address/data/

This is a massive file (500+ MB once extracted) and something like 1.9 million records. The supplied importer will work but it's very slow: you should only use it for a smaller subset of files, or as a last resort for the entire set. You should sideload it using mysqladmin or a similar database tool.

Use the 0.0.x tags for SilverStripe 3 installations.  SilverStripe 4 support will be handled from versions 0.1.x.
