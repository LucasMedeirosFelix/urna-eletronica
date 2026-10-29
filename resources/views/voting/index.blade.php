
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Urna Eletrônica</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        body {
            background: #eef2f7;
            font-family: Arial, sans-serif;
        }

        .urna {
            max-width: 850px;
            margin: 40px auto;
            padding: 28px;
            background: white;
            border-radius: 18px;
            box-shadow: 0 8px 30px #00000012;
        }

        .candidato {
            border: 2px solid #dee2e6;
            border-radius: 12px;
            padding: 18px;
            cursor: pointer;
        }

        .candidato:has(input:checked) {
            border-color: #198754;
            background: #effaf3;
        }

        .numero {
            font-size: 28px;
            font-weight: bold;
            color: #198754;
        }
    </style>
</head>
<body>
<div class="container">
    <main class="urna">
        <h1 class="text-center mb-2">Urna Eletrônica</h1>
        <p class="text-center text-secondary">
            Eleição de demonstração
        </p>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                Verifique a opção selecionada e tente novamente.
            </div>
        @endif

        <form method="POST" action="{{ route('voting.store') }}">
            @csrf

            <h2 class="h5 mb-3">Escolha seu candidato</h2>

            <div class="row g-3">
                @forelse ($candidates as $candidate)
    <div class="col-md-6">
        <label class="candidato d-block h-100">

            <input
                type="radio"
                name="candidate_id"
                value="{{ $candidate->id }}"
                class="form-check-input me-2"
                required
            >

            <img
                src="{{ asset('storage/' . $candidate->image) }}"
                alt="{{ $candidate->name }}"
                class="img-fluid rounded mb-3"
                style="max-width: 200px; height: 180px; object-fit: cover;"
            >

            <h3 class="h5 mt-2">
                {{ $candidate->name }}
            </h3>

        </label>
    </div>
@empty
    <div class="col-12">
        <p class="alert alert-warning">
            Nenhuma imagem cadastrada ainda.
        </p>
    </div>
@endforelse
            </div>

            <input type="hidden" name="type" id="type" value="candidate">

            <div class="d-grid gap-2 mt-4">
                <button
                    type="submit"
                    class="btn btn-success btn-lg"
                    onclick="return confirm('Deseja confirmar este voto?')"
                >
                    CONFIRMAR VOTO
                </button>

                <button
                    type="button"
                    class="btn btn-outline-secondary"
                    onclick="votarEspecial('blank')"
                >
                    VOTO EM BRANCO
                </button>

                <button
                    type="button"
                    class="btn btn-outline-danger"
                    onclick="votarEspecial('null')"
                >
                    VOTO NULO
                </button>
            </div>
        </form>
    </main>
</div>

<script>
    function votarEspecial(tipo) {
        document.querySelectorAll(
            'input[name="candidate_id"]'
        ).forEach(input => input.checked = false);

        document.getElementById('type').value = tipo;

        const formulario = document.querySelector('form');

        // Os votos em branco e nulo não precisam de candidato.
        formulario.querySelectorAll(
            'input[name="candidate_id"]'
        ).forEach(input => input.required = false);

        if (confirm('Deseja confirmar esta opção?')) {
            formulario.submit();
        } else {
            document.querySelectorAll(
                'input[name="candidate_id"]'
            ).forEach(input => input.required = true);

            document.getElementById('type').value = 'candidate';
        }
    }
</script>
</body>
</html>
