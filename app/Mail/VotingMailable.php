<?php

namespace App\Mail;

use App\Models\Authentication\System;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VotingMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    private $data;
    private $pathAttaches;
    private $system;

    public function __construct($subject, $data, $pathAttaches = null, $system = null)
    {
        $this->subject = $subject;
        $this->data = $data;
        $this->pathAttaches = $pathAttaches;

        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);

        $this->system = $system == null ? System::firstWhere('code', $catalogues['system']['code']) : $system;

    }

    public function build()
    {
        if (!is_null($this->pathAttaches)) {
            foreach ($this->pathAttaches as $pathAttach) {
                $this->attachFromStorage('public/temp_files/' . $pathAttach);
            }
        }

        return $this->view('mails.voting')
            ->with(['data' => json_decode($this->data), 'system' => $this->system]);
    }
}
