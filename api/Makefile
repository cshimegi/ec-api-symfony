SEPARATOR := "====================================================================="
PROCESS := $(shell date +"%T")" [Execute] ===> "
FORMAT_PHP_FOLDERS := src tests

# help
.DEFAULT_GOAL: help
.PHONY: help
help:
	@echo "Format all php files                   : make format-all"
	@echo "Format php files under src directory   : make format-src"
	@echo "Format php files under tests directory : make format-tests"
	@echo "Run server by symfony                  : make run-server"

# run server
.PHONY: run-server
run-server:
	symfony server:start

# format php files
.PHONY: format-all format-src format-tests $(FORMAT_PHP_FOLDERS)
format-all: $(FORMAT_PHP_FOLDERS)
$(FORMAT_PHP_FOLDERS):
	@echo $(SEPARATOR)
	@echo "Formatting php files under [$@] directory..."
	prettier "./$@/**/*.php" --write
	@echo $(SEPARATOR)

format-src:
	@echo $(SEPARATOR)
	@echo "Formatting php files under src directory..."
	prettier "./src/**/*.php" --write
	@echo $(SEPARATOR)

format-tests:
	@echo $(SEPARATOR)
	@echo "Formatting php files under tests directory..."
	prettier "./src/**/*.php" --write
	@echo $(SEPARATOR)
