build:
	docker build . -t fomento

bash:
	docker run -v $(shell pwd)/app:/app:rw -it fomento bash

install:
	docker run -v $(shell pwd)/app:/app:rw fomento composer install