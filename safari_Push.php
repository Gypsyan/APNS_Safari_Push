<?php
/*Enable to add debug*/
$debug = 1;
$push_apple = 'ssl://gateway.push.apple.com:2195';

// Your website Certificate pem
$certificate = 'PushCertKey.pem';

//Your pem password
$passphrase = 'push';

//Your Token
$token = 'Add Your device Token here';

$ctx = stream_context_create();
if ( $ctx === FALSE ) {
  $error = "Error with stream context";
  if ( $debug ) {
    echo $error.'<br/>'.PHP_EOL;
  }
} else {
  $stream_success = stream_context_set_option( $ctx, 'ssl', 'local_cert',$certificate );
  if ( $stream_success === FALSE ) {
    $error = "Error with stream context option local_cert";
    if ( $debug ) {
      echo $error.'<br/>'.PHP_EOL;
    }
  } else {
    $stream_success = stream_context_set_option( $ctx, 'ssl', 'passphrase', $passphrase );
    if ( $stream_success === FALSE ) {
      $error = "Error with stream context option ssl";
      if ( $debug ) {
        echo $error.'<br/>'.PHP_EOL;
      }
    } else {
      $stream_success = stream_context_set_option( $ctx, 'ssl', 'cafile', 'Entrust.net Certification Authority (2048).pem.pem' );
    }
  }
}


// Open a connection to the APNS server
if ( !$error ) {
  $fp = stream_socket_client(
  $push_apple, $err,
  $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx );
  if ( $fp === FALSE ) {
    $error = "Failed to connect debug: $err $errstr";
    if ( $debug ) {
      echo $error.'<br/>'.PHP_EOL;
    }
  } else {

    if ( $debug ) {
      echo 'Connected to APNS<br/>'.PHP_EOL;
    }

    // Create the payload body
    // We are using an intermediary page (last_newsletters.php) to be able
    // to check whether or not the user has read the newsletter.

    $title = 'This is tile';
    $message = 'This is the message';
    $action = 'viewe';
    $url_arg = 'www.google.com';

    $body = array(
      'aps' => array(
        'alert' => array(
          'title' => $title,
          'body' => $message,
          'action' => $action,
        ),
      ),
      'url-args' => array($url_arg),
    );

    // Encode the payload as JSON
    $payload = json_encode( $body );

    // Build the binary notification
    $msg = chr( 0 ).pack( 'n', 32 ).pack( 'H*', $token ).pack( 'n', strlen( $payload ) ).$payload;

    // Send it to the server
    $result = fwrite( $fp, $msg, strlen( $msg ) );

    echo $result;
    if ( !$result ) {
      if ( $debug ) {
        echo 'Message not delivered (token='.$token.')<br/>'.PHP_EOL;
      }
      $invalidDeviceTokens[] = $ios_id;
    } else {
      if ( $debug ) {
        echo 'Message successfully delivered (token='.$token.')<br/>'.PHP_EOL;
      }
    }
    $res = fclose( $fp );
    echo "\nfclose : ".$res;
  }
}

if ( $error ) {
  $body = $error;
  $result = '';
}
var_dump( $payload);
