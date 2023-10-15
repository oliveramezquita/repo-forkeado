<?php

namespace App\Console\Commands;

use App\Models\Syllabi\SyllabiBP\SyllabiBP;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use \App\Models\Admin\SchoolYear;
use \App\Models\Admin\SchoolSettings;
use Illuminate\Support\Carbon;

class CheckSyllabiToArchive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-syllabi-to-archive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This triggers everytime a enrollment opens, and basically takes all the active syllabis and copies them to archive_syllabi.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('Running cron... - Checking if the syllabi has to be copied for the upcoming enrollment...');
        $this->info('Checking if the syllabi has to be copied for the first time...');

        $schoolSettings = SchoolSettings::first();

        if (!$schoolSettings) {
            $this->info('The school has not set up the school settings.');
            return;
        }

        $today = Carbon::now();

        // This may happen only once
        if ($schoolSettings->current_enrollment && $today->gte($schoolSettings->current_enrollment)) {
            // If the current year syllabis archive count is bigger than 0, it means it has already been copied, so do not copy
            $current_schoolYear = SchoolYear::getSchoolYear();

            if ($current_schoolYear->syllabis->count() > 0) {
                $this->info('The syllabi has already been copied.');
            } else {
                $this->info('The syllabi has to be archived.');

                // Archive the syllabis for the current school year
                SyllabiBP::archiveSyllabis($current_schoolYear);
            }
        }

        // This happens every year
        if ($schoolSettings->next_enrollment && $today->gte($schoolSettings->next_enrollment)) {
            // If the next year syllabis archived count is bigger than 0, it means it has already been copied, so do not copy
            $next_schoolYear = SchoolYear::getNextSchoolYear();

            if ($next_schoolYear->syllabis->count() > 0) {
                $this->info('The syllabi has already been copied.');
            } else {
                $this->info('The syllabi has to be archived.');

                // Archive the syllabis for the current school year
                SyllabiBP::archiveSyllabis($next_schoolYear);
            }
            
        }

        return;
    }
}
