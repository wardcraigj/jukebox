<?php

namespace App\Listeners;

use App\Events\SomeEvent;
use App\Events\SongChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use lxmpd;

class SongChangedEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SomeEvent  $event
     * @return void
     */
    public function handle(SongChanged $event)
    {
        //
        //\Log::alert('song change event fired');
        echo "song change event fired" . PHP_EOL;

        if(($event->status['nextsongid'] == 0) && (config('jukebox.jukebox_mode')) ){
            if(lxmpd::playlistExists('jukebox.jukebox_mode')){
                //todo: queue song from playlist

            } else {

            	$songFound = false;

	            while(!$songFound){
		            $song = $this->getRandomSong();

		            if($song['file']){
			            $songURI = $song['file'];
			            $songFound = true;
		            }
	            }

                lxmpd::queue($songURI);
                
            }
        }
    }

    private function getRandomSong(){
	    $songs = lxmpd::runCommand('listall');

	    $queuesong = array_rand ($songs,1);

	    $song = $songs[$queuesong];

	    return $song;
	}
}
