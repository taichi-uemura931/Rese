<?php

namespace App\Console\Commands;

use App\Models\Reservation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\ReminderMail;

class ScheduleReservationTasks extends Command
{
    protected $signature = 'reservations:daily-tasks';
    protected $description = 'Send reminder emails and update visited status daily.';

    public function handle()
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        $reservationsToday = Reservation::with('user', 'restaurant')
            ->whereDate('date', $today)
            ->get();

        foreach ($reservationsToday as $reservation) {
            Mail::to($reservation->user->email)->send(new ReminderMail($reservation));
        }

        $updatedCount = Reservation::whereDate('date', '<', $today)
            ->where('visited', false)
            ->update(['visited' => true]);

        $this->info("リマインダー送信: {$reservationsToday->count()} 件 / visited 更新: {$updatedCount} 件");
    }
}
