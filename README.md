# Trainsys API

## ✍️ Descrição do Projeto

O projeto Trainsys API consiste em uma API REST desenvolvida em Laravel 10, criada para complementar o frontend do Trainsys, uma solução para profissionais de educação física e para academias.
A API gerencia usuários, estudantes, exercícios e treinos, proporcionando uma integração eficiente entre o frontend e o backend, completa para suportar todas as funcionalidades do sistema.

## 🔧 Tecnologias Utilizadas

-   Laravel 10
-   PostgreSQL
-   DOMPDF (para a geração de PDF)

## 💼 Requisitos do Sistema

Certifique-se de ter as seguintes ferramentas instaladas antes de executar o projeto:

-   **[Composer](https://getcomposer.org/)**: Gerenciador de dependências para PHP. Instale com o comando `composer install`.

-   **[Docker](https://www.docker.com/)**: Plataforma de criação de conteiners para facilitar a configuração do ambiente.

-   **[DBeaver](https://dbeaver.io/)**: Ferramenta de gerenciamento de banco de dados para visualizar e interagir com o PostgreSQL.

## ⏸️ Executando o Projeto

1. Clone o repositório.
- `git clone https://github.com/fabiopdidio/ProjetoModulo2`

2. Configure o ambiente Laravel.
- Crie um arquivo .env na raiz do projeto, copie o conteúdo de .env.example e cole no arquivo.

3. Execute as migrations e seed para configurar o banco de dados: 
- `php artisan migrate --seed`

4. Instale as dependências do projeto: 
- `composer install`

### 🚥 Endpoints - Rotas Usuários

-  ```POST /api/users```: Cadastra um novo usuário.
```http
{
  "name": "Neymar Jr",
  "email": "ney@gmail.com",
  "date_birth": "1990-12-08",
  "cpf": "111.141.190.44",
  "password": "senha1234",
  "plan_id": 2
}
```

-   ```POST /api/login```: Realiza o login de um usuário.
```http
{
  "email": "ney@gmail.com",
  "password": "senha1234"
}
```

-   ```GET /api/dashboard```: Retorna os dados cadastrados para o dashboard.
```http
{
  "registered_students": 10,
  "registered_exercises": 30,
  "current_user_plan": "Plano prata",
  "remaining_students": 10
}
```

### 🚥 Endpoints - Rotas Exercícios

-   ```POST /api/exercises```: Cria e cadastra um novo exercício.
```http
{
  "description": "Rosca direta"
}
```

-   ```GET /api/exercises```: Lista os exercícios do usuário logado.
```http
{
  "id": 1,
  "description": "Rosca direta"
}
```

-   ```DELETE /api/exercises/{id}```: Deleta um exercício através do seu ID.

### 🚥 Endpoints - Rotas Estudantes

-   ```POST /api/students```: Cadastra um novo estudante.
-   ```GET /api/students```: Lista estudantes do usuário logado.
-   ```DELETE /api/students/{id}```: Deleta um estudante por ID com o uso de soft delete.
-   ```PUT /api/students/{id}```: Atualiza dados de um estudante por ID.

### 🚥 Endpoints - Rotas Treinos

-   ```POST /api/workouts```: Cadastra um novo treino.
-   ```GET /api/students/{id}/workouts```: Lista os treinos do estudante por ID.
-   ```GET /api/students/{id}```: Lista todos dados de um estudante por ID.
-   ```GET /api/students/export?id_do_estudante={id}```: Exporta o treino do estudante em formato PDF.

## 🔜 Melhorias Futuras

-   Adicionar mais campos para especificação de exercícios.
-   Fazer a integração com uma API externa como o ViaCEP para apenas com o CEP retornar todos dados.
-   Adicionar autenticação com JSON Web Tokens (JWT) em outras rotas.
-   Aumenta os limites de cadastro de estudantes, permitindo maior número de estudantes por professor.

---

**Desenvolvido por Fábio Didio**
