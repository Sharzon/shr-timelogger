<?php

use Illuminate\Database\Seeder;
use App\Activity;
use Carbon\Carbon;

class ActivitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $start = Carbon::today();
        $end = Carbon::today();

        $activity = new Activity();
        $activity->name = "Eat";
        $activity->start = $start->hour(14)->minute(30);
        $activity->end = $end->hour(14)->minute(53);
        $activity->save();

        $activity = new Activity();
        $activity->name = "Sleep";
        $activity->start = $start->hour(15)->minute(30);
        $activity->end = $end->hour(20)->minute(15);
        $activity->save();

        $activity = new Activity();
        $activity->name = "Rave";
        $activity->start = $start->hour(23)->minute(00);
        $activity->end = $end->addDay()->hour(5)->minute(53);
        $activity->save();

        $activity = new Activity();
        $activity->name = "Repeat";
        $activity->start = $start->addDay()->hour(14)->minute(30);
        $activity->end = $end->addDay();
        $activity->save();        
    }
}
