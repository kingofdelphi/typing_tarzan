#TYPING TARZAN

Multiplayer typing website which can be deployed using docker.

From the root folder(containg docker-compose.yml) follow these steps.

1. docker-compose build
2. docker-compose up
3. goto http://localhost:8080 on your browser
4. you can change hostname by modifying docker-compose.yml SERVER_HOSTNAME variable


TODO:
need to add cnf to /etc/mysql/my.cnf if to use port other than 3306 for mysql
