<?php
    // Contact form strings
    if ( defined('ICL_LANGUAGE_CODE') ) {
        if ( 'ICL_LANGUAGE_CODE' == "en") {
?>
var not_human       = "Human verification incorrect.",
            missing_content = "Please supply all information.",
            email_invalid   = "Email Address Invalid.",
            message_unsent  = "Message was not sent. Try Again.",
            message_sending = "Sending message, please wait",
            message_sent    = "Thanks! Your message has been sent.",
            message_empty   = "Empty message.",
            failure_message = 'Whoops, looks like there was a problem. Please try again later.';
<?php
        } elseif ( 'ICL_LANGUAGE_CODE' == "nb" ) {
?>
var not_human       = "Menneskelig verifisering feilet.",
            missing_content = "Vennligst fyll ut alle felt.",
            email_invalid   = "Epost-addresse er feil utfyllt",
            message_unsent  = "Din medling ble ikke sendt, prøv igjen.",
            message_sending = "Sender melding, vennligst vent",
            message_sent    = "Takk, din melding ble sendt. Vi kontakter deg så snart som mulig.",
            message_empty   = "Tom meldingsboks.",
            failure_message = 'Opps, Et problem har oppstått. Vennligst prøv igjen senere.';
<?php
        }
    } else { ?>
var not_human       = "Menneskelig verifisering feilet.",
            missing_content = "Vennligst fyll ut alle felt.",
            email_invalid   = "Epost-addresse er feil utfyllt",
            message_unsent  = "Din medling ble ikke sendt, prøv igjen.",
            message_sending = "Sender melding, vennligst vent",
            message_sent    = "Takk, din melding ble sendt. Vi kontakter deg så snart som mulig.",
            message_empty   = "Tom meldingsboks.",
            failure_message = 'Opps, Et problem har oppstått. Vennligst prøv igjen senere.';
<?php
    }
?>
