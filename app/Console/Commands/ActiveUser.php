<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ActiveUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:active_user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change status user from limit to active';

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
    public function handle()
    {
        $this->info('Start the command!');
        $current_date = date('Y-m-j');
        $newdate = strtotime('-3 day', strtotime($current_date));
        $newdate = date('Y-m-d', $newdate);

        try {
            $users = User::where('status', 'L')
                    ->whereDate('date_limit', '<=', $newdate)
                    ->get();

            if (!count($users)) {
                $this->info('The command was successful!');
                return 0;
            }

            DB::beginTransaction();
            foreach($users as $user) {
                $user->update([
                    'date_limit' => null,
                    'status' => 'A'
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            $this->error('Something went wrong!');
            return 1;
        }

        $this->info('The command was successful!');
        return 0;
    }
}
