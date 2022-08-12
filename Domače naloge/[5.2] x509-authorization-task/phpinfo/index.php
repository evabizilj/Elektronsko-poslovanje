<?php
        # avtorizirani uporabniki 
        $authorized_users = ["Ana"];

        # preberemo odjemačev certifikat
        $client_cert = filter_input(INPUT_SERVER, "SSL_CLIENT_CERT");

        # in ga razčlenemo
        $cert_data = openssl_x509_parse($client_cert);
        
        # preberemo ime uporabnika (polje "common name")
        $commonname = $cert_data['subject']['CN'];

        # ime se nahaja na seznamu avtoriziranih uporabnikov
        if (in_array($commonname, $authorized_users)) {
            phpinfo(-1);
        } else {
            echo "$commonname ni avtoriziran uporabnik.";
        }
?>


