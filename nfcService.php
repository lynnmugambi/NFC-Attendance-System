<?php

phpinfo();

if (!extension_loaded('pcsc')) {
    dl('php_pcsc.dll');
}

# Get a PC/SC context
$context = scard_establish_context();
//var_dump($context);

# Get the reader list
$readers = scard_list_readers($context);
//var_dump($readers);

# Use the first reader
$reader = $readers[0];
echo "Using reader: ", $reader, "\n";

# Connect to the card
$connection = scard_connect($context, $reader);
//var_dump($connection);

# Select Applet APDU
$CMD = "00A404000AA00000006203010C0601";
$res = scard_transmit($connection, $CMD);
var_dump($res);

# test APDU
$CMD = "00000000";
$res = scard_transmit($connection, $CMD);
var_dump($res);
echo pack("H*", $res), "\n";

# Release the PC/SC context
scard_release_context($context);

?>
