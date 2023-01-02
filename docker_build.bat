docker build -t sat . --no-cache
docker run -dit -p 8099:8080  --name sat -v C:/CETAapps/ServiceAcceptanceTool:/var/www/html ServiceAcceptanceTool
