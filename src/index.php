<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <title>Gestão de Stock - API</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Catálogo de Produtos</h2>
    
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form id="formProduto" class="row g-3">
                <div class="col-md-6">
                    <input type="text" id="nome" class="form-control" placeholder="Nome do Produto" required>
                </div>
                <div class="col-md-3">
                    <input type="number" step="0.01" id="preco" class="form-control" placeholder="Preço (R$)" required>
                </div>
                <div class="col-md-3">
                    <input type="number" id="quantidade" class="form-control" placeholder="Quantidade" required>
                </div>
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary">Adicionar Produto</button>
                </div>
            </form>
        </div>
    </div>

    <table class="table table-white table-hover shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Preço (R$)</th>
                <th>Quantidade</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody id="lista"></tbody>
    </table>
</div>

<script>
    const API = 'api.php?path=produtos';

    async function carregar() {
        const res = await fetch(API);
        const dados = await res.json();
        const lista = document.getElementById('lista');
        lista.innerHTML = dados.map(p => `
            <tr>
                <td>${p.id}</td>
                <td>${p.nome}</td>
                <td>${p.preco}</td>
                <td>${p.quantidade}</td>
                <td><button class="btn btn-sm btn-danger" onclick="remover(${p.id})">Remover</button></td>
            </tr>
        `).join('');
    }

    document.getElementById('formProduto').onsubmit = async (e) => {
        e.preventDefault();
        const payload = {
            nome: document.getElementById('nome').value,
            preco: document.getElementById('preco').value,
            quantidade: document.getElementById('quantidade').value
        };
        await fetch(API, {
            method: 'POST',
            body: JSON.stringify(payload),
            headers: {'Content-Type': 'application/json'}
        });
        e.target.reset();
        carregar();
    };

    async function remover(id) {
        if(confirm('Remover produto?')) {
            await fetch(API + '/' + id, { method: 'DELETE' });
            carregar();
        }
    }

    carregar();
</script>
</body>
</html>