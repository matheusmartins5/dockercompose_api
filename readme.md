# API RESTful PHP com MySQL via Docker Compose

Este projeto entrega um ambiente com múltiplos containers (PHP/Apache e MySQL), estruturando uma API RESTful para gerenciamento de produtos.

## 🚀 Como fazer o deploy do ambiente

1. Clone este repositório para a sua máquina.
2. Certifique-se de que o Docker e o Docker Compose estão instalados.
3. No terminal, navegue até a pasta do projeto e execute:
   ```bash
   docker-compose up -d --build


## Endpoints e Métodos

1. Criar Produto
Método: Post
Endpoint: /api.php?path=produtos
Exemplo de JSON:
{
    "nome": "Notebook",
    "preco": 3500.00,
    "quantidade": 15
}

2. Listar todos os produtos
Método: GET
Endpoint: /api.php?path=produtos

3. Obter produto por ID
Método: GET
Endpoint: /api.php?path=produtos/{id}
Exemplo: /api.php?path=produtos/1

4. Atualizar produto
Método: PUT
Endpoint: /api.php?path=produtos/{id}
Exemplo de JSON:
{
    "nome": "Notebook Gamer",
    "preco": 4200.00,
    "quantidade": 10
}

5. Deletar produto
Método: DELETE
Endpoint: /api.php?path=produtos/{id}
Exemplo: /api.php?path=produtos/1