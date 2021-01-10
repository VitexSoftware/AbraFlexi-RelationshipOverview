composer:
	composer update

dimage:
	docker build -t vitexsoftware/abraflexi-relationship-overview .

dtest:
	docker-compose run --rm default install
        
drun: dimage
	docker run  -dit --name RelationshipOverview -p 9999:80 vitexsoftware/abraflexi-relationship-overview

