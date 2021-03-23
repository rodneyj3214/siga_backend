<?php

namespace App\Mail;

use App\Models\Authentication\System;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuthMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    private $data;
    private $pathAttaches;

    public function __construct($subject, $data, $pathAttaches = null)
    {
        $this->subject = $subject;
        $this->data = $data;
        $this->pathAttaches = $pathAttaches;
    }

    public function build()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        $system = System::firstWhere('code', $catalogues['system']['code']);

        if (!is_null($this->pathAttaches)) {
            foreach ($this->pathAttaches as $pathAttach) {
                $this->attachFromStorage('public/temp_files/'.$pathAttach);
            }
        }

        return $this->view('mails.unlock-user')
            ->with(['data' => json_decode($this->data), 'system' => $system]);
    }
}
