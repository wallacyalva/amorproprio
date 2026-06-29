# 💖 API REST - Sistema da Associação Amor Próprio

Este projeto é uma API RESTful desenvolvida em Laravel para o gerenciamento de conteúdo institucional, atividades, publicações e mídias da **Associação Amor Próprio**. O sistema foi projetado com uma arquitetura dividida entre o consumo público de dados (para o site/front-end) e a administração privada (painel de controle), garantindo segurança através de autenticação via tokens.

---

## 🛠️ Requisitos do Sistema

Para rodar este projeto localmente, você precisará ter instalado em sua máquina:
* **PHP 8.2+** (Recomendado via XAMPP)
* **Composer** (Gerenciador de dependências do PHP)
* **MySQL** (Servidor de banco de dados)
* **Git**

---

## 🚀 Passo a Passo de Instalação e Configuração

**1. Clone o repositório e acesse a pasta**
```bash
git clone https://github.com/wallacyalva/amorproprio
cd amorproprio
```

**2. Instale as dependências do framework**
```bash
composer install
```

**3. Configure o Ambiente (.env)**
Copie o arquivo de exemplo para criar o seu arquivo de configuração local:
```bash
cp .env.example .env
```
Abra o arquivo `.env` gerado e configure a conexão com o banco de dados (ajuste a senha se o seu root não for vazio):
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=academia_db
DB_USERNAME=root
DB_PASSWORD=
```
*Dica para ambiente de desenvolvimento:* Altere `APP_DEBUG=true` no seu arquivo `.env` para visualizar mensagens de erro detalhadas diretamente nas respostas da API em caso de falha.

**4. Crie as Chaves de Segurança (Criptografia e JWT)**
O Laravel e o sistema de autenticação JWT exigem chaves secretas para gerar tokens. Rode os comandos abaixo:
```bash
php artisan key:generate
php artisan jwt:secret
```
Limpe o cache para garantir que as chaves foram carregadas:
```bash
php artisan config:clear
php artisan cache:clear
```

**5. Crie o Banco de Dados no MySQL**
Abra o seu gerenciador de banco de dados (ex: MySQL Workbench ou phpMyAdmin) e execute:
```sql
CREATE SCHEMA amor_proprio_db;
```

**6. Rode as Migrations e os Seeders**
Este comando cria todas as tabelas na ordem correta e popula o banco com os dados iniciais:
```bash
php artisan migrate:fresh --seed
```

**7. Inicie o Servidor**
```bash
php artisan serve
```
A API estará rodando em `http://127.0.0.1:8000`. Utilize o **Postman** ou **Insomnia** para testar as rotas (Lembre-se de usar o Header `Accept: application/json` nas suas requisições).

---

## 🔐 Credenciais de Acesso (Testes)

Ao rodar o comando de Seeders (passo 6), um usuário administrador padrão é criado automaticamente no banco de dados para permitir o acesso às rotas privadas. Utilize as seguintes credenciais na rota de Login (POST /api/auth/login) para gerar o seu token de acesso (JWT):
### E-mail: amor@proprio.com
### Senha: 123456

## 🧠 Entendendo a Arquitetura (O Caminho do Dado)

Para facilitar a compreensão do código e da estrutura da API, abaixo explicamos o fluxo de desenvolvimento e a divisão das rotas.

### 1. Banco de Dados e Migrations (A Base)
As migrations foram construídas para mapear as entidades principais da Associação, criando tabelas como:

1. `users`: Usuários administradores do sistema.
2. `posts`: Artigos e notícias publicadas pela ONG.
3. `activities`: Atividades, eventos e cronogramas.
4. `media`: Gerenciamento de fotos, vídeos e assets visuais.
5. `texts`: Textos institucionais e dinâmicos para exibição no front-end.

### 2. Rotas (routes/api.php)
O sistema de rotas foi arquitetado para separar claramente o que é público do que é administrativo, protegendo informações sensíveis:
1. `Rotas Públicas (/public/)`: Métodos GET abertos (media, post, activity, text) feitos exclusivamente para o Front-end consumir e renderizar a interface visual sem necessidade de autenticação.
2. `Rota de Auth (/auth/)`: Responsável por autenticar o usuário e emitir o token JWT.
3. `Rotas Privadas (/v1/)`: Protegidas pelo middleware auth:api. Utiliza o padrão apiResource para fornecer um CRUD completo, permitindo que apenas administradores logados possam criar, editar e excluir registros.

### 3. Form Requests e Validações
Todas as inserções de dados (POST/PUT) passam por classes de validação (Requests). Isso garante que campos obrigatórios (como o título de um post ou a URL de uma mídia) sejam preenchidos corretamente antes de atingirem o banco de dados, retornando erros claros em formato JSON (Status 422 Unprocessable Entity) caso algo falhe.

### 4. Controllers e ORM (O Cérebro)
A lógica de negócio centraliza-se nos Controllers (ex: PostController, ActivityController), utilizando o poder do Eloquent ORM do Laravel para manipular o banco de dados sem a necessidade de queries SQL manuais.

O sistema utiliza formatação de respostas JSON limpas e, quando necessário, Eager Loading para entregar os dados relacionados de forma rápida e eficiente para as requisições HTTP do cliente.

**Link do projeto em Producao**
```bash
https://amorproprio.free.nf/
```
