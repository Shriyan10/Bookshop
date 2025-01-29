docker stop bookshop
docker rm bookshop
docker run -p 9900:9900 --name bookshop --env-file .env mnzit/bookshop:latest