<?php

use App\Models\Appointment;
use App\Models\Bug;
use App\Models\Service;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/consultar', function () {
    return view('consultar');
});

Route::post('/consultar', function (Request $request) {
    $appointments = Appointment::where('client_cpf', $request->client_cpf)->get();
    return view('/consultar', compact('appointments'));
});

Route::get('/', function () {
    $services = Service::where('is_active', true)->get();
    return view('agendamento', compact('services'));
});

Route::post('/', function (Request $request) {
    try {
        // Create the appointment
        $appointment = Appointment::create([
            'client_name' => $request->client_name,
            'client_cpf' => $request->client_cpf,
            'service_id' => $request->service_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => 'Agendado'
        ]);

        return view('confirmacao', [
            'appointment' => $appointment,
            'success' => 'Agendamento realizado com sucesso!' // Passa como variável, não via session
        ]);
    } catch (\Exception $e) {
        return back()
            ->with('error', 'Ocorreu um erro ao agendar. Por favor, tente novamente.')
            ->withInput();
    }
});

Route::post('/reportar', function (Request $request) {
    try {

        $bug = Bug::create([
            'description' => $request->description,
            'resvolved' => 0,
        ]);

        return back()
            ->with('success', 'Bug reportado com sucesso!');
    } catch (\Exception $e) {
        return back()
            ->with('error', 'Ocorreu um erro ao reportar o bug. Por favor, tente novamente.')
            ->withInput();
    }
});

Route::get('/reportar', function () {
    return view('bug');
});
