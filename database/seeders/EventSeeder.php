<?php

namespace Database\Seeders;
use App\Traits\Uuid;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{

    use Uuid;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create 5 active event dummy data
        for ($i = 1; $i <= 10; $i++) {
            if($i % 2 == 0){
                $n=2;
            } else if($i % 3 == 0){
                $n=3;
            }else {
                $n=1;
            }
            DB::table('events')->insert([
                'id' => Str::Uuid(),
                'name' => 'Event '.$i,
                'slug' => 'event_'.$i,
                'startAt' => Carbon::now()->subDays($n)->startOfWeek(),
                'endAt' => Carbon::now()->addMonths($n+1)->endOfWeek(),
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
               ]);


        }

        //create 5 inactive event dummy data
        for ($i = 1; $i <= 10; $i++) {
            if($i % 2 == 0){
                $n=2;
            } else if($i % 3 == 0){
                $n=3;
            }else {
                $n=1;
            }
            DB::table('events')->insert([
                'id' => Str::Uuid(),
                'name' => 'Events '.$i,
                'slug' => 'events_'.$i,
                'startAt' => Carbon::now()->subMonth($n)->startOfWeek(),
                'endAt' => Carbon::now()->subMonth($n-1)->endOfWeek(),
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
               ]);


        }
    }
}  