# Librarianship service
The librarianship service is implemented with php language. This service will allow you to search and reserve books and also user can see his borrowed books and End of Borrowing Time for his books.

To launch this service, we first create a container from the PHP image and then place the code files inside ```./volume/project/book/ ```folder in your directory to mount this file to ```/var/www/html ``` directory in container. 
This service needs to be connected to the database service to perform its function, so there must be a link between the two services. To create a container for this service and link it to database service, we used the composite file and linked the two services
### create a container with compose file
> In the Compose file, the specification of this service is as follows:
```docker compose
 book:
    image: php:5.6-apache
    container_name: book
    #restart: always
    links:
      - db_service:db_service_host
    volumes:
      - ./volume/project/book/:/var/www/html
    ports:
      - 82:80
      - 445:443
    networks:
      mor_net:
        ipv4_address: 172.100.100.140             

```
after you careate compose file, you must ```cd ``` to folder that contain this file and run ```docker-compose up -d``` command to build unit container.
hopefully, you can see this container in result of ```docker-compose ps``` command :)

because we use ```mysqli_connect()``` function to put/get data in db_service container,we must install mysqli extension in our container with this commands:
```
Docker exec –it book sh
docker-php-ext-install mysqli
docker-php-ext-enable mysqli
apachectl restart
```

if you can need to inspect this container, you must use ```docker inspect book``` ;)

### implementation with PHP

This service has three parts:
1. Book reserve: first a list of books for reserving show to the user. The user can reserve books. He can also cancel his reserved books.
2. Book Search: In this section, the user can customize the search by title, author name or topic.
3. Borrowed Book List: Shows a list of borrowed books for the user. It also shows the status of returned books.
