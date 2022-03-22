<h1 align="center">
	Symfony DDD Example 
</h1>

### Application execution

1. Run `docker-compose build --pull --no-cache` to build fresh images
2. Run `docker-compose up` (the logs will be displayed in the current shell)
3. The project will be ready on `https://localhost`
4. Open https://localhost in browser and accept the auto-generated TLS certificate
5. Run `docker-compose down --remove-orphans` to stop the Docker containers.

## Some project and approach explanations

I have realized this project with basic CRUD operations like CREATE, READ, UPDATE, DELETE handlers with DDD 
structure and CQRS approach.<br>
I have used default symfony framework with DoctrineORM.<br>
I have written some basic test using phpunit, but unfortunately not enough for covering all the most important cases 
to meet limited time for this task. <br>
Also I didn't realise all possible crud operation, because all of them will look similar way, coding will look like 
copy\paste and it is time consuming thing. <br>
Also I want to say that maybe I have chosen not the optimal approach for CRUD operations, but description of the task 
doesn't get me additional context how it is going to use in "business", so that I've decided just to do it to 
provide possibility to create entities, assign it to each other and get all information about entities.<br>
All http query examples are provided in <b> /share </b> folder. Also I have put there postman.json collection with 
all query examples, just to import it.

### Hexagonal architecture
I have tried to follow the Hexagonal Architecture pattern where the app layer can use domain implementations only and 
the infrastructure layer must implement domain interfaces in order to be completely independent.

### CQRS
Application logic was split to "Commands" and "Queries" depending on the action to be performed.

### How to start using this project

1) Run <pre>$ docker-compose exec php sh</pre>
2) Run command <pre> bin/console doctrine:schema:create </pre> to create db schema
3) Run command <pre> bin/console doctrine:fixtures:load </pre> to load all data provided for this assessment task
4) Create user: <pre>$ bin/console app:create-user test@mail.com test ROLE_ADMIN</pre>
5) Generate auth keys <pre>$ bin/console  lexik:jwt:generate-keypair</pre>
6) Get authorization token for this user:
<pre>
curl --location --request POST 'http://localhost/authentication_token' \
   --header 'Content-Type: application/json' \
   --data-raw '{
       "email": "test@mail.com",
       "password": "test"
     }'</pre>
5) Use this token to make queries for getting or creating data:
<pre>
   curl --location --request POST 'https://localhost/api/interest/' \
      --header 'Content-Type: application/json' \
      --header 'Authorization: Bearer {TOKEN}' \
      --data-raw ' {
         "name": "interest 1"
      }'</pre>
6) Get interest by id:
<pre>
    curl --location --request GET 'https://localhost/api/interest/{interest_id}'
</pre>
7) Run tests <pre> docker-compose exec php sh -c 'bin/phpunit' </pre>
