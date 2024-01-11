none:

buildimage:
	docker build -f Dockerfile  -t vitexsoftware/abraflexi-relationship-overview:latest .

buildx:
	docker buildx build  -f Dockerfile  . --push --platform linux/arm/v7,linux/arm64/v8,linux/amd64 --tag vitexsoftware/abraflexi-relationship-overview:0.2.5

drun:
	docker run  -f Dockerfile --env-file .env vitexsoftware/abraflexi-relationship-overview:0.2.5

