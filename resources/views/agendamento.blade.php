<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Agendamento</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

</head>

<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Cabeçalho -->
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Novo Agendamento</h1>
                <a href="/reportar" class="text-red-600 hover:text-red-800">
                    <i class="fa-solid fa-circle-exclamation"></i> Reportar Bug
                </a>
                <a href="/consultar" class="text-blue-600 hover:text-blue-800">
                    <i class="fa-solid fa-magnifying-glass"></i> Consultar
                </a>
            </div>


            <!-- Card do Formulário -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <form action="/" method="POST">
                    @csrf

                    <div class="mb-6">
                        <label for="client_name" class="block text-sm font-medium text-gray-700 mb-2">Nome</label>
                        <input id="client_name" name="client_name" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Seu nome completo" />
                    </div>

                    <div class="mb-6">
                        <label for="client_cpf" class="block text-sm font-medium text-gray-700 mb-2">Nome</label>
                        <input id="client_cpf" name="client_cpf" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Seu CPF" />
                    </div>

                    <!-- Serviço -->
                    <div class="mb-6">
                        <label for="service_id" class="block text-sm font-medium text-gray-700 mb-2">Serviço</label>
                        <select id="service_id" name="service_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Selecione um serviço</option>
                            @foreach($services as $service)
                            <option value="{{ $service->id }}">{{ $service->name }} ({{ $service->duration }} min)</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Data e Hora de Início -->
                    <div class="mb-6">
                        <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">Data</label>
                        <input type="date" id="start_time" name="start_time" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Data e Hora de Término -->
                    <!-- Hora de Início -->
                    <div class="mb-6">
                        <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">Hora de Início</label>
                        <select id="end_time" name="end_time" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Selecione um horário</option>
                            <!-- Gerar opções das 08:00 às 18:00 em intervalos de 30 minutos -->
                            @php
                            $start = strtotime('08:00');
                            $end = strtotime('13:30');
                            $interval = 30 * 60; // 30 minutos em segundos
                            @endphp
                            @for($i = $start; $i <= $end; $i +=$interval)
                                <option value="{{ date('H:i', $i) }}">{{ date('H:i', $i) }}</option>
                                @endfor
                        </select>
                    </div>


                    <!-- Botão de Submit -->
                    <div class="flex justify-end">
                        <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Agendar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Máscara para CPF com validação básica
            $('#client_cpf').mask('000.000.000-00', {
                placeholder: '___.___.___-__',
                onKeyPress: function(cpf, e, field, options) {
                    // Remove todos os caracteres não numéricos
                    const cpfDigits = cpf.replace(/\D/g, '');

                    // Validação básica do tamanho (opcional)
                    if (cpfDigits.length === 11) {
                        console.log('CPF completo:', cpf);
                    }
                }
            });

            // Validação ao submeter o formulário
            $('form').on('submit', function(e) {
                const cpfDigits = $('#client_cpf').val().replace(/\D/g, '');
                if (cpfDigits.length !== 11) {
                    e.preventDefault();
                    alert('Por favor, insira um CPF válido com 11 dígitos');
                }
            });
        });
    </script>
</body>

</html>