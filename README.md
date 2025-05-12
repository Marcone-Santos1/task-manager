# Manual de Instalação com Laravel Sail

## Pré-requisitos
- Docker Desktop instalado
- Git instalado

## Passo a Passo

1. Clone o repositório e instale o sail:
   ```bash
   git clone https://github.com/Marcone-Santos1/task-manager.git
   cd task-manager
   ```

### Backend

1. Entre no ambiente 
    ```bash
    cd backend
    ```
   
2. Configure o ambiente:
   ```bash
   cp .env.example .env
   ```

3. Instale o sail:
   ```bash
    docker run --rm \
    -p 8080:80 \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs
   ```

4. Suba os containers e gere a key:
   ```bash
   ./vendor/bin/sail up -d

   ./vendor/bin/sail artisan key:generate
   ```
   
5. Execute as migrações e seeders:
   ```bash
   ./vendor/bin/sail artisan migrate
   ```

---

### Frontend

1. Volte para a raiz e entre no ambiente frontend
    ```bash
    cd .. && cd frontend
    ```

2. Configure o ambiente:
   ```bash
   cp .env.example .env
   ```

3. Inicie o container
    ```bash
    docker-compose up -d
    ```
    
### Inicie também com um comando make (Após configuração inicial)

1. Rode
    ```bash
    make start
    ```

## Comandos Úteis

| Comando                      | Descrição                              |
|------------------------------|----------------------------------------|
| `./vendor/bin/sail up -d`    | Inicia os containers em background     |
| `./vendor/bin/sail stop`     | Para os containers                     |
| `./vendor/bin/sail bash`     | Acessa o container principal           |
| `./vendor/bin/sail mysql`    | Acessa o MySQL                         |
| `./vendor/bin/sail artisan`  | Executa comandos Artisan               |
| `./vendor/bin/sail test`     | Executa os testes PHP                  |