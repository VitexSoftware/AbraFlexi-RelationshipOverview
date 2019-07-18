#all: fresh build

composer:
	composer update

dimage:
	docker build -t vitexsoftware/flexibee-relationship-overview .

dtest:
	docker-compose run --rm default install
        
drun: dimage
	docker run  -dit --name RelationshipOverview -p 9999:80 vitexsoftware/flexibee-relationship-overview


