.DEFAULT_GOAL := help
SHELL=/bin/bash

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
.PHONY: help

CONTAINER_ID := $(shell docker ps -qf "name=shopware6SHOP")
CONTAINER_IMAGE := $(shell docker inspect -f "{{.Config.Image}}" $(shell docker ps -qf "name=shopware6SHOP"))

build-image: ## Run build image
	docker cp ./cleanup.sh $(CONTAINER_ID):/tmp/
	docker exec $(CONTAINER_ID) bash -c "sudo chmod +x /tmp/cleanup.sh && sudo /tmp/cleanup.sh"
	docker commit $(CONTAINER_ID) $(CONTAINER_IMAGE)
	docker build -t $(CONTAINER_IMAGE) .
	docker login --username krusemediendev
	docker push $(CONTAINER_IMAGE)
.PHONY: build-image