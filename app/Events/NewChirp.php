<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class NewChirp
{
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Chirp $chirp)
    {
        //
    }
}
