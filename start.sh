#launch websocket server
cd /typingtarzan
php bin/chat-server.php &

#launch cake web server
cd webroot
../bin/cake server -H 0.0.0.0 -p 8080
