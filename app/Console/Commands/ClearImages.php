<?php

namespace App\Console\Commands;

use App\Models\Image;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClearImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clearImages';

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
    public function handle() {
        $images = array_merge(
            DB::table("films")->pluck("poster")->toArray(),
            DB::table("person")->pluck("photo")->toArray(),
        );
        $files = scandir('storage\\images\\');
        unset($files[0]);
        unset($files[1]);
        foreach ($files as $image) {
            if (!in_array($image, $images)) {
                Image::deleteImage($image);
                $this->warn($image." was removed!");
            }
        }
        return 0;
    }
}
