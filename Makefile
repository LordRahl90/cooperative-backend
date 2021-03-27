
ci: build-image push

push:
	docker push lordrahl/coop-backend:latest

build-image:
	docker build -f .docker/app.dockerfile -t lordrahl/coop-backend:latest .

run:
	docker-compose -f .docker/docker-compose.yml up

enter:
	docker exec -it coop-backend bash

stop:
	docker-compose -f .docker/docker-compose.yml kill
