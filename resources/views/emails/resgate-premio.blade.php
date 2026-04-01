<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Novo resgate de prêmio</title>
</head>
<body>
    <h2>Novo resgate de prêmio realizado</h2>

    <h3>Dados do usuário</h3>
    <p><strong>Nome:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Telefone:</strong> {{ $user->telefone ?? 'Não informado' }}</p>
    <p><strong>RRT:</strong> {{ $user->rrt ?? 'Não informado' }}</p>

    <h3>Dados do prêmio</h3>
    <p><strong>Prêmio:</strong> {{ $premio->nome }}</p>
    <p><strong>Descrição:</strong> {{ $premio->descricao }}</p>
    <p><strong>Pontos do prêmio:</strong> {{ number_format($premio->pontos, 0, ',', '.') }}</p>

    <h3>Dados do resgate</h3>
    <p><strong>ID do resgate:</strong> {{ $resgate->id }}</p>
    <p><strong>Pontos gastos:</strong> {{ number_format($resgate->pontos_gasto, 0, ',', '.') }}</p>
    <p><strong>Saldo antes:</strong> {{ number_format($saldoAntes, 0, ',', '.') }}</p>
    <p><strong>Saldo depois:</strong> {{ number_format($saldoDepois, 0, ',', '.') }}</p>
    <p><strong>Data:</strong> {{ $resgate->created_at->format('d/m/Y H:i:s') }}</p>
</body>
</html>