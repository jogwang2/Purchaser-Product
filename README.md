# Purchaser-Product
Rest Api involving creating products, purchasers, and purchased products 

Pre-requisite:
1. Symfony 4 is installed
2. MySQL is installed
3. Make sure Apache and MySQL services are running (I usually use xampp app to start/stop these services)

Setup:
1. download the files in this repository
2. execute the /db_scripts/create_tables.sql to create the necessary tables (db_user should be "root")
   // you can also edit the .env file for a different db config
3. to test the api, run symfony server:start at the repository's root
4. using Postman, you can now check the following endpoints
   a. POST /purchaser 
      - sample body: "{ "name": "Bob" }"
   b. POST /product
      - sample body: "{ "name": "Tomato" }"
   c. POST /purchaser-product
      - sample body: "{ "purchaser_id": 1,
         "product_id": 5,
         "purchase_timestamp": 1566265701 }"
   d. GET /purchaser/{$purchaser_id}/product?start_date={$start_date}&end_date={$end_date}


