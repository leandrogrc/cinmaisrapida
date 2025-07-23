<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação de Agendamento</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-md p-8 max-w-md w-full">

        <!-- Título -->
        @if(isset($success))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ $success }}
        </div>
        @endif

        <!-- Detalhes do Agendamento -->
        <div class="space-y-4">
            <div class="flex justify-between border-b pb-2">
                <span class="font-semibold text-gray-600">Cliente:</span>
                <span id="client_name">{{$appointment->client_name}}</span>
            </div>

            <div class="flex justify-between border-b pb-2">
                <span class="font-semibold text-gray-600">CPF:</span>
                <span id="client_cpf">{{$appointment->client_cpf}}</span>
            </div>

            <div class="flex justify-between border-b pb-2">
                <span class="font-semibold text-gray-600">Serviço:</span>
                <span id="service_id">{{$appointment->service->name}}</span>
            </div>

            <div class="flex justify-between border-b pb-2">
                <span class="font-semibold text-gray-600">Data:</span>
                <span id="start_time">{{ \Carbon\Carbon::parse($appointment->start_time)->format('d-m-Y') }}</span>
            </div>

            <div class="flex justify-between border-b pb-2">
                <span class="font-semibold text-gray-600">Horário:</span>
                <span id="end_time">{{$appointment->end_time}}</span>
            </div>

            <div class="flex justify-between">
                <span class="font-semibold text-gray-600">Status:</span>
                <span id="status" class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">{{$appointment->status}}</span>
            </div>
        </div>

        <!-- Botões de Ação -->
        <div class="mt-8 flex justify-between">
            <a href="/" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                Voltar
            </a>
            <button onclick="window.print()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Imprimir
            </button>
        </div>
    </div>
    <script src="https://cdn.tailwindcss.com"></script>
</body>

</html>