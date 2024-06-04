docker build -t sat --no-cache  --progress=plain  . 2> build.log
docker run -dit -p 8099:8080  --name sat -v C:/CETAapps/ServiceAcceptanceTool:/var/www/html  --env-file C:/CETAapps/ServiceAcceptanceTool/.env sat
