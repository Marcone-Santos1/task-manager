# Task Manager – Manual de Instalação com Laravel Sail

## 📋 Pré-requisitos

* [Docker Desktop](https://www.docker.com/products/docker-desktop/) instalado
* [Git](https://git-scm.com/downloads) instalado

---

* Obs: instalação utilizando Ubuntu (wsl)

## 🚀 Passo a Passo

### 🔧 Clonando o repositório

```bash
git clone https://github.com/Marcone-Santos1/task-manager.git
cd task-manager
```

---

### ⚙️ Backend (Laravel)

1. Acesse o diretório `backend`:

```bash
cd backend
```

2. Copie o arquivo `.env` de exemplo:

```bash
cp .env.example .env
```

3. Instale as dependências com Sail:

```bash
docker run --rm \
  -p 8080:80 \
  -u "$(id -u):$(id -g)" \
  -v "$(pwd):/var/www/html" \
  -w /var/www/html \
  laravelsail/php84-composer:latest \
  composer install --ignore-platform-reqs
```

4. Suba os containers e gere a chave da aplicação:

```bash
./vendor/bin/sail up -d
./vendor/bin/sail artisan key:generate
```

5. Execute as migrações e seeders:

```bash
./vendor/bin/sail artisan migrate
```

---

### 🎨 Frontend (Vanilla JS + Vite)

1. Volte para a raiz do projeto e acesse o diretório `frontend`:

```bash
cd .. && cd frontend
```

2. Copie o arquivo `.env` de exemplo:

```bash
cp .env.example .env
```

3. Inicie os containers:

```bash
docker-compose up -d
```

---

### 💡 Dica: Uso do Makefile (após configuração inicial)

Para facilitar, você pode iniciar o projeto com:

```bash
make start
```

---

## 🛠️ Comandos Úteis

| Comando                     | Descrição                                 |
| --------------------------- | ----------------------------------------- |
| `./vendor/bin/sail up -d`   | Inicia os containers em segundo plano     |
| `./vendor/bin/sail stop`    | Para os containers                        |
| `./vendor/bin/sail bash`    | Acessa o container principal              |
| `./vendor/bin/sail mysql`   | Acessa o banco de dados MySQL             |
| `./vendor/bin/sail artisan` | Executa comandos Artisan                  |
| `./vendor/bin/sail test`    | Executa os testes automatizados (PHPUnit) |
