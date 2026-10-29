<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gerenciar imagens</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>
<body class="bg-light">
<div class="container py-5">

    <h1 class="mb-4">Gerenciar imagens da urna</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card mb-5">
        <div class="card-body">
            <h2 class="h4">Adicionar nova opção</h2>

            <form
                action="{{ route('admin.images.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nome da opção</label>
                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name') }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Número único</label>
                    <input
                        type="text"
                        name="number"
                        class="form-control"
                        value="{{ old('number') }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Partido ou categoria (opcional)
                    </label>
                    <input
                        type="text"
                        name="party"
                        class="form-control"
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Escolher imagem</label>
                    <input
                        type="file"
                        name="image"
                        class="form-control"
                        accept="image/jpeg,image/png,image/webp"
                        required
                    >
                </div>

                <button class="btn btn-success">
                    Adicionar opção
                </button>
            </form>
        </div>
    </div>

    <h2 class="h4 mb-3">Opções já cadastradas</h2>

    <div class="row g-4">
        @foreach ($candidates as $candidate)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    @if ($candidate->image)
                        <img
                            src="{{ asset('storage/' . $candidate->image) }}"
                            class="card-img-top"
                            alt="{{ $candidate->name }}"
                            style="height: 220px; object-fit: contain;"
                        >
                    @endif

                    <div class="card-body">
                        <h3 class="h5">{{ $candidate->name }}</h3>

                        <form
                            action="{{ route('admin.images.update', $candidate) }}"
                            method="POST"
                            enctype="multipart/form-data"
                        >
                            @csrf

                            <label class="form-label">
                                Escolher outra imagem
                            </label>

                            <input
                                type="file"
                                name="image"
                                class="form-control mb-3"
                                accept="image/jpeg,image/png,image/webp"
                                required
                            >

                            <button class="btn btn-primary">
                                Trocar imagem
                            </button>
                        </form>
                        <form
    action="{{ route('admin.images.destroy', $candidate) }}"
    method="POST"
    class="mt-2"
    onsubmit="return confirm('Tem certeza de que deseja excluir esta opção?');"
>
    @csrf
    @method('DELETE')

    <button type="submit" class="btn btn-danger w-100">
        Excluir opção
    </button>
</form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <a href="{{ route('voting.index') }}"
       class="btn btn-secondary mt-4">
        Voltar para a urna
    </a>

</div>
</body>
</html>
