Examples
========

I created a VueJS app to demonstrate autocomplete functionality with this module.

Setup
-----
Initialise a yarn project, or create this package.json:
```
{
  "name": "nzstreets",
  "version": "1.0.0",
  "main": "index.js",
  "license": "MIT",
  "devDependencies": {
    "laravel-mix": "^1.6.1",
    "vue": "^2.5.2",
    "webpack": "^3.8.1"
  },
  "scripts": {
    "dev": "NODE_ENV=development node_modules/webpack/bin/webpack.js --progress --hide-modules --config=node_modules/laravel-mix/setup/webpack.config.js",
    "watch": "NODE_ENV=development node_modules/webpack/bin/webpack.js --watch --progress --hide-modules --config=node_modules/laravel-mix/setup/webpack.config.js",
    "hot": "NODE_ENV=development webpack-dev-server --inline --hot --config=node_modules/laravel-mix/setup/webpack.config.js",
    "production": "NODE_ENV=production node_modules/webpack/bin/webpack.js --progress --hide-modules --config=node_modules/laravel-mix/setup/webpack.config.js"
  },
  "dependencies": {
    "vuejs-auto-complete": "^0.6.2"
  }
}
```

Install all yarn packages.


Create a webpack.mix.js file in your webroot:
```
let mix = require('laravel-mix').mix;
mix.js('./themes/<yourtheme>/javascript/app.js', './themes/<yourtheme>/javascript/app.dist.js');
mix.sass('./themes/<yourtheme>/scss/app.scss', './themes/<yourtheme>/css/app.dist.css');
```

Create `javascript/app.js`

```
import Vue from 'vue';
import Autocomplete from 'vuejs-auto-complete';


var addressLookup = new Vue({
    el: '#address-lookup',
    components: {
        'autocomplete': Autocomplete,
    },
    data: {
    },
    props: ['address', 'AddressID', 'AddressLine1', 'Suburb', 'City'],
    data: {

    },
    methods: {
        getDetails: function(address) {

            this.AddressID = address.selectedObject.value;
            this.AddressLine1 = address.selectedObject.AddressLine1;
            this.Suburb = address.selectedObject.Suburb;
            this.City = address.selectedObject.City;

        }
    }

})

```

Create a template to include in your Page layouts (`Includes/AddressLookup.ss`):

```
<div id="address-lookup">
    <label>Your address</label>
    <autocomplete
        name="AddressID"
        placeholder="Start typing your address"
        :model="address"
        source="/address/search/?q="
        results-property="addresses"
        results-value="AddressID"
        results-display="FullAddress"
        input-class="form-control form-control-lg"
        @selected="getDetails">
    </autocomplete>
    <small>Please provide your address in this format: <em>55 Cable St, Te Aro, Wellington</em></small>

    <div v-if="AddressLine1">
        <div class="row">
            <div class="col col-md-12">
                <div class="form-group">
                    <label for="AddressLine1">House number and street name</label>
                    <input id="AddressLine1" class="form-control" type="text" name="AddressLine1" :value="AddressLine1"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col col-md-6">
                <div class="form-group">
                    <label for="Suburb">Suburb</label>
                    <input id="Suburb" class="form-control" type="text" name="Suburb" :value="Suburb"/>
                </div>
            </div>

            <div class="col col-md-6">
                <div class="form-group">
                    <label for="City">City</label>
                    <input id="City" class="form-control" type="text" name="City" :value="City"/>
                </div>
            </div>
        </div>
    </div>
</div>
```

Include your template in the layout somewhere, like Layout/HomePage.ss:

```
	<section class="jumbotron">
        <div class="container-fluid">
            <h1>$Title</h1>
            $Content

            <% include AddressLookup %>
        </div>
	</section>
    $Form
    $CommentsForm

```

Don't forget to include your compiled javascript at the end of the `HomePage.ss` template:
```
    <% require themedJavascript("app.dist") %>
</body>
</html>
```
