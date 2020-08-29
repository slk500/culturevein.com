 Please visit site https://culturevein.com
The base functionaliy of this app it's my 'idée fixe' but I like try new things & fool around a little bit so 
my apology for being inconsistent in design.     

Right know as a part of experiment I'm trying to remove OOP objects on use only functions.

To run project:
1. run command in public_html 'php -S localhost:8000'
2. run command in frontend 'ng serve' 
3. run database docker run -p 3306:3306 -e MYSQL_DATABASE='mysqldb' -e MYSQL_ALLOW_EMPTY_PASSWORD='yes' -d mysql
4. import database from db dir

* To Do List
    * Add new tag time, if already exist and is red - delete before add new
    * TODO Check if all YT links works
    * TODO script to download all music videos from precise tag, cut only the tag scenes, glue them in one video  
    * TODO Mailing
        * TODO notification of tags subscription
        * TODO notification of changes to your tags 
        * TODO notifications of changes to video that you added
        * TODO tags subscription   
        
* Naming:
  * PHP
    * variables - snake_case
  * JS
    * variables - camelCase
  * JSON API
    * variables - snake_case  
    * TODO https://jsonapi.org/format/