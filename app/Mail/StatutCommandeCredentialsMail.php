<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StatutCommandeCredentialsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $commande;

    /**
     * Create a new message instance.
     *
     * @param string $email
     * @param string $password
     */
    public function __construct($email, $commande)
    {
        $this->email = $email;
        $this->commande = $commande;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Commande payé avec succés')
                    ->view('emails.factures') 
                    ->with([
                        'email' => $this->email,
                        'commande' => $this->commande
                    ]);
    }
}