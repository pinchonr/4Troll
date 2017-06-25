In order to create the database and insert line required for tests, please follow those instructions:

USING DOCKER:

You will need to change those configuration files:

* config.yml
* parameters.yml
* parameters.yml.dist (ensure element IS commented)


-------- config.yml --------
doctrine:
    dbal:
        driver: '%database.driver%'
        host: '%database.host%'
        port: '%database.port%'
        dbname: '%database.name%'
        user: '%database.user%'
        password: '%database.password%'
        charset: UTF8


-------- parameters.yml --------
parameters:
    database_driver: pdo_mysql #in our case
    database_host: ## see under ##
    database_port: 3306
    database_name: symfony
    database_user: root
    database_password: root

    #swiftmailer configuration
    mailer_transport: smtp
    mailer_host: 127.0.0.1
    mailer_user: null
    mailer_password: null
    secret: SymfonyRequiresASecret

-------- parameters.yml --------
# You should uncomment this if you want to use pdo_sqlite
#database_path: '%kernel.root_dir%/../var/data/data.sqlite'


docker run --detach --name mysql -e MYSQL_ROOT_PASSWORD=root -d mysql

docker inspect mysql

Find the element named "IPAddress" (example: "IPAddress": "172.17.0.2"). This IP is to change in the project configurations (database_host).

You can now run:

php bin/console doctrine:database:create

php bin/console doctrine:schema:update --force



You can access the databases directly with the IP address found above by running the following command:

mysql -u root -proot -h #IP_ADDRESS# -P 3306


Please run the given SQL file (default.sql) in order to be able to run tests.

