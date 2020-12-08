Configure the hosts file
```bash
$ sudo nano /etc/hosts
```
add new line
```bash
127.0.0.1 test-ezlogz.local
```

Run the project environment run
```bash
$ docker-compose up
```
To get in to the container as non root user run
```bash
docker exec -it test_ezlogz_php_1 su dev
```
