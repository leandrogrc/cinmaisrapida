<?php

// app/Filament/Resources/AppointmentResource/Pages/CalendarAppointments.php
namespace App\Filament\Resources\AppointmentResource\Pages;

use App\Filament\Resources\AppointmentResource;
use Filament\Resources\Pages\Page;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarAppointments extends Page
{
    protected static string $resource = AppointmentResource::class;
    protected static string $view = 'filament.resources.appointment-resource.pages.calendar-appointments';

    protected function getHeaderWidgets(): array
    {
        return [
            CalendarWidget::class,
        ];
    }
}

// app/Filament/Resources/AppointmentResource/Widgets/CalendarWidget.php
namespace App\Filament\Resources\AppointmentResource\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use App\Models\Appointment;

class CalendarWidget extends FullCalendarWidget
{
    public function fetchEvents(array $fetchInfo): array
    {
        return Appointment::query()
            ->where('start_time', '>=', $fetchInfo['start'])
            ->where('end_time', '<=', $fetchInfo['end'])
            ->get()
            ->map(
                fn(Appointment $appointment) => [
                    'title' => $appointment->client->name . ' - ' . $appointment->service->name,
                    'start' => $appointment->start_time,
                    'end' => $appointment->end_time,
                    'url' => AppointmentResource::getUrl('edit', ['record' => $appointment]),
                    'color' => $this->getStatusColor($appointment->status),
                ]
            )
            ->all();
    }

    protected function getStatusColor(string $status): string
    {
        return match ($status) {
            'scheduled' => '#3b82f6', // blue
            'confirmed' => '#10b981', // green
            'canceled' => '#ef4444', // red
            'completed' => '#8b5cf6', // purple
            default => '#64748b', // slate
        };
    }
}
