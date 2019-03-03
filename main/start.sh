#wait for mysql
#while true; do
#	echo Connecting to SQL
#	mysql -h mariadb --database=ttar
#	if [ $? -eq 0 ]; then
#		break
#	fi
#	sleep 5
#done

#launch websocket server
cd /typingtarzan
php bin/chat-server.php &

#launch cake web server
cd webroot
../bin/cake server -H 0.0.0.0 -p $HTTP_PORT
