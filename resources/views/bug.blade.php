<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportar Bug</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white rounded-lg shadow-md p-8 max-w-md w-full">

        <div class="flex justify-between w-full"> <!-- flex + espaçamento horizontal de 4 unidades (1rem) -->
            <a href="/" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition-colors duration-200">
                <i class="fa-solid fa-calendar-days mr-2"></i> Agendar
            </a>
            <a href="/consultar" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition-colors duration-200">
                <i class="fa-solid fa-magnifying-glass"></i> Consultar
            </a>
        </div>
        <!-- Cabeçalho -->
        <div class="text-center mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <h1 class="text-2xl font-bold text-gray-800 mt-2">Reportar Problema</h1>
            <p class="text-gray-600 mt-2">Descreva o bug encontrado com detalhes</p>
        </div>

        <!-- Mensagens de Erro/Sucesso -->
        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
        @endif

        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif

        <!-- Formulário -->
        <form action="/reportar" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descrição do Bug *</label>
                <textarea
                    id="description"
                    name="description"
                    rows="5"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Ex: Ao clicar no botão X na página Y, ocorre Z..."
                    required>{{ old('description') }}</textarea>
            </div>

            <!-- Campo oculto para resolved -->
            <input type="hidden" name="resolved" value="0">

            <div class="flex items-center">
                <input
                    required
                    id="contact"
                    name="contact"
                    type="checkbox"
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="contact" class="ml-2 block text-sm text-gray-700">
                    Estou ciente de que não devo reportar falsos bugs.
                </label>
            </div>

            <div>
                <button
                    type="submit"
                    class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-4 rounded-md transition duration-200">
                    Reportar Bug
                </button>
            </div>
        </form>

        <!-- Rodapé -->
        <div class="mt-6 text-center text-sm text-gray-500">
            <p>Nossa equipe será notificada e trabalhará para corrigir o problema.</p>
        </div>
    </div>
</body>

</html>