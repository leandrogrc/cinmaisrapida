<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Agendamentos</title>
    <!-- CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- jQuery e jQuery Mask -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Cabeçalho -->
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Consultar Processo</h1>
                <a href="/reportar" class="text-red-600 hover:text-red-800">
                    <i class="fa-solid fa-circle-exclamation"></i> Reportar Bug
                </a>
                <a href="/" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                    <i class="fa-solid fa-calendar-days"></i> Novo Agendamento
                </a>
            </div>

            <!-- Formulário de Busca -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <form action="/consultar" method="POST">
                    @csrf
                    @method('POST')
                    <div class="flex items-end gap-4">
                        <div class="flex-grow">
                            <label for="client_cpf" class="block text-sm font-medium text-gray-700 mb-2">CPF</label>
                            <input type="text" id="client_cpf" name="client_cpf" value="{{ old('client_cpf') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Digite seu CPF" required>
                        </div>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md">
                            <i class="fas fa-search mr-2"></i>Buscar
                        </button>
                    </div>
                </form>
            </div>

            <!-- Resultados -->
            @if(isset($appointments) && $appointments->count() > 0)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <!-- Cabeçalho da Tabela -->
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-lg font-medium text-gray-800">Resultados da Busca</h2>
                    @if(old('client_cpf'))
                    <p class="text-sm text-gray-600 mt-1">Buscando por CPF: "{{ old('client_cpf') }}"</p>
                    @endif
                </div>

                <!-- Tabela de Agendamentos -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Serviço</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data/Hora</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($appointments as $appointment)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $appointment->client_name }}</div>
                                    <div class="text-sm text-gray-500">{{ $appointment->client_cpf }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $appointment->service->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $appointment->service->duration }} minutos</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($appointment->start_time)->format('d/m/Y') }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($appointment->end_time)->format('H:i') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                    $statusColors = [
                                    'Agendado' => 'bg-blue-100 text-blue-800',
                                    'Confirmado' => 'bg-green-100 text-green-800',
                                    'Cancelado' => 'bg-red-100 text-red-800',
                                    'Concluído' => 'bg-purple-100 text-purple-800'
                                    ];
                                    @endphp
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$appointment->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $appointment->status }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @elseif(request()->isMethod('post'))
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-12 text-center">
                    <i class="fas fa-calendar-times text-4xl text-gray-400 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900">Nenhum agendamento encontrado</h3>
                    <p class="mt-1 text-sm text-gray-500">Não foram encontrados agendamentos para este CPF.</p>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Notificações -->
    @if(session('success'))
    <div class="fixed top-4 right-4 z-50">
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-lg max-w-sm">
            <div class="flex items-center">
                <svg class="h-6 w-6 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <div>
                    <p class="font-bold">Sucesso!</p>
                    <p>{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-green-500 hover:text-green-700">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    @endif

    <script>
        $(document).ready(function() {
            // Máscara para CPF com validação básica
            $('#client_cpf').mask('000.000.000-00', {
                placeholder: '___.___.___-__',
            });
        });
    </script>
</body>

</html>