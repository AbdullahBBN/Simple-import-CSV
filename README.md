# Import App:
The task involves a basic data source (csv-file with basic product data), importing that data and
mapping it to a database. The csv-file is attached as well.

## Setup:
1) composer install
2) copy .env.example to .env
3) Config database connection to local machine
4) php artisan migrate
5) php artisan queue:work
6) php artisan serve
7) visit localhoast:8000


## What has been done:
1) Create the view to upload CSV files (resources/views/import/index.blade.php)
2) Create the model and controller of the product
3) Create Product repository with 3 function (findAll(), findOneByName(), removeAll())
4) The controller contians 4 function:
   1) importCSVFile function => get the file input content and pass it to EXCEl import pacakge to start the background import job and redirect home
   2) removeAll function => call the product repo to remove all product and remove cache
   3) getSingleProduct function => call the product repo to find one by name
   4) getAllProduct function => first check if product are cached then get from the cache otherwise get from database 
5) web.php contains 2 route:
    1) "/" this home page to upload the CSV files
    2) "/import" the import action with background job
6) api.php contains 3 routes:
    1) "/removeAll"
    2) "/getSingleProduct"
    3) "/getAllProduct"
7) app/Imports/ProductsImport.php => the excel package using this file to map the csv row input with the product model
8) Excel package => https://docs.laravel-excel.com/3.1/getting-started/
