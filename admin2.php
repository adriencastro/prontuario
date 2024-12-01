<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área Administrativa</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h1>Área Administrativa</h1>
    <h2>Lista de alunos</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Data</th>
                <th>Observação</th>
            </tr>
        </thead>
        <tbody id="tabela-alunos">
            <!-- Os alunos serão adicionados aqui dinamicamente -->
        </tbody>
    </table>

    <script>
        // Função para carregar os alunos
        async function carregaralunos() {
            try {
                // Faz uma requisição ao endpoint
                const resposta = await fetch('listar_alunos.php');
                const alunos = await resposta.json();

                const tabelaalunos = document.getElementById('tabela-alunos');
                tabelaalunos.innerHTML = ''; // Limpa a tabela antes de adicionar os novos alunos

                if (alunos.length > 0) {
                    alunos.forEach(aluno => {
                        const linha = document.createElement('tr');

                        linha.innerHTML = `
                            <td>${aluno.id}</td>
                            <td>${aluno.nome}</td>
                            <td>${aluno.data}</td>
                            <td>${aluno.observacao}</td>
                        `;

                        tabelaalunos.appendChild(linha);
                    });
                } else {
                    tabelaalunos.innerHTML = '<tr><td colspan="4">Nenhum aluno encontrado.</td></tr>';
                }
            } catch (erro) {
                console.error('Erro ao carregar os alunos:', erro);
            }
        }

        // Carregar os alunos ao carregar a página
        document.addEventListener('DOMContentLoaded', carregaralunos);
    </script>
</body>
</html>