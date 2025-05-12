# Caminhos para os diretórios do back e do front
BACK_DIR = ./backend
FRONT_DIR = ./frontend

# Comando padrão para rodar o docker-compose
DOCKER_COMPOSE = docker-compose

# Tarefa para iniciar os containers do back e do front
start:
	@echo "Iniciando o Docker Compose para os dois projetos..."
	$(DOCKER_COMPOSE) -f $(BACK_DIR)/docker-compose.yml up -d --build
	$(DOCKER_COMPOSE) -f $(FRONT_DIR)/docker-compose.yml up -d --build

# Tarefa para parar os containers dos dois projetos
stop:
	@echo "Parando os containers..."
	$(DOCKER_COMPOSE) -f $(BACK_DIR)/docker-compose.yml down
	$(DOCKER_COMPOSE) -f $(FRONT_DIR)/docker-compose.yml down

# Tarefa para reiniciar os containers
restart:
	@echo "Reiniciando os containers..."
	$(DOCKER_COMPOSE) -f $(BACK_DIR)/docker-compose.yml down
	$(DOCKER_COMPOSE) -f $(FRONT_DIR)/docker-compose.yml down
	$(DOCKER_COMPOSE) -f $(BACK_DIR)/docker-compose.yml up -d --build
	$(DOCKER_COMPOSE) -f $(FRONT_DIR)/docker-compose.yml up -d --build
