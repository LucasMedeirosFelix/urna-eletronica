<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Apuração da Eleição</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <h1 class="h3">Apuração dos votos</h1>
            <p class="text-secondary">
                Resultados da eleição de demonstração
            </p>

            <div class="alert alert-info">
                Total de votos registrados:
                <strong>{{ $totalVotes }}</strong>
            </div>

            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Número</th>
                            <th>Candidato</th>
                            <th>Votos</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($candidates as $candidate)
                            <tr>
                                <td>{{ $candidate->number }}</td>
                                <td>{{ $candidate->name }}</td>
                                <td>{{ $candidate->votes_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <p>
                Votos em branco:
                <strong>{{ $blankVotes }}</strong>
            </p>

            <p>
                Votos nulos:
                <strong>{{ $nullVotes }}</strong>
            </p>

            <a href="{{ route('voting.index') }}"
               class="btn btn-success">
                Voltar para a urna
            </a>
        </div>
    </div>
</div>
</body>
</html>
