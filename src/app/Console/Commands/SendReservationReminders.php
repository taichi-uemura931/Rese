<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendReservationReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    protected function handle()
    {
        $today = now()->format('Y-m-d');

        $reservations = Reservation::with(['user', 'restaurant'])
            ->where('date', $today)
            ->get();

        foreach ($reservations as $reservation) {
            Mail::to($reservation->user->email)
                ->send(new ReservationReminderMail($reservation));
        }
    }
}
