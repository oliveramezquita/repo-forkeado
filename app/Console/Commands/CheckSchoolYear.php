<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use \App\Models\Admin\SchoolYear;
use \App\Models\Admin\SchoolSettings;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CheckSchoolYear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-school-year';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Given the day of today, and the end of the course, check if the school year has to be updated to the next one.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('Running cron... - Checking if the school year has to be updated...');
        $this->info('Checking if the school year has to be updated...');
    
        $schoolSettings = SchoolSettings::first();
        $schoolYear = SchoolYear::getSchoolYear();
    
        if (!$schoolSettings || !$schoolYear) {
            $this->error('School settings or school year not found.');
            return;
        }
    
        $today = Carbon::now();

        if ($schoolSettings->ending_time && $today->gte(Carbon::parse($schoolSettings->ending_time))) {
            $this->info('The school year has to be updated, and so the settings of the school.');

            try {
                DB::beginTransaction();

                // Activate the next school year and deactivate the current one
                $next_schoolYear = SchoolYear::getNextSchoolYear();
                $schoolYear->is_active = false;
                $schoolYear->save();
                $next_schoolYear->is_active = true;
                $next_schoolYear->save();

                // Create the next school year
                SchoolYear::createNextScholarYear();

                // Update the school settings
                $schoolSettings->current_enrollment = $schoolSettings->next_enrollment;
                $schoolSettings->next_enrollment = null;
                $schoolSettings->starting_time = null;
                $schoolSettings->ending_time = null;
                $schoolSettings->save();

                DB::commit();

                $this->info('The school year has been updated from ' . $schoolYear->start_year . '-' . $schoolYear->end_year . ' to ' . $next_schoolYear->start_year . '-' . $next_schoolYear->end_year . '.');
            } catch (\Exception $e) {
                $this->error('Error updating the school year.');
                return;
            }
        } else {
            $this->info('The school year does not have to be updated.');
        }
    }
}
