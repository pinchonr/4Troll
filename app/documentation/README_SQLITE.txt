In order to create the database and insert line required for tests, please follow those instructions:

USING SQLITE:

You will need to change those configuration files:

* config.yml
* parameters.yml
* parameters.yml.dist (ensure element IS NOT commented)


-------- config.yml --------
doctrine:
    dbal:
        driver: '%database.driver%'
        path: '%database_path%''


-------- parameters.yml --------
parameters:
    database_path: #PATH TO YOUR DATABASE (ABSOLUTE OR RELATIVE USING %kernel.root_dir%/your/path/to/database.db) PRO TIP: put database in the /var/ folder of your symfony app#
    database_user: root #in our case
    database_password: root #in our case
    memory: false  #True if the SQLite database should be in-memory (non-persistent). Mutually exclusive with path. path takes precedence.

    #swiftmailer configuration
    mailer_transport: smtp
    mailer_host: 127.0.0.1
    mailer_user: null
    mailer_password: null
    secret: SymfonyRequiresASecret

-------- parameters.yml --------
# You should uncomment this if you want to use pdo_sqlite
database_path: '%kernel.root_dir%/../var/data/data.sqlite'


You can now run :

php bin/console doctrine:database:create

php bin/console doctrine:schema:update --force


You can access the database by running the following command at the root of the project :

sqlite3 ./var/symfony.db

Please run the given SQL file (default.sql) in order to be able to run tests.

If it doesn't work please register a new user: 

Surname: testeur
Name: testeur
Username: testeur
password: testeur
email: testeur@test.fr

and make him add a content.