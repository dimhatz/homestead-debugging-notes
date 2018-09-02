<?php
// How to disable output buffering so that the output from echo line prints line by line
// and is visible "in real time" when stepping over, instead of just showing all at once.

// With apache, changing these lines in php.ini are enough:
// These are STILL NEEDED with nginx!
// implicit_flush = On
// output_buffering = 0 (or Off)
// zlib.output_compression = Off

// This line added in the beginning of the script works without modifying nginx's settings in homestead.
// It eliminates both proxy_buffering and (if you have nginx >= 1.5.6), fastcgi_buffering. The fastcgi bit is crucial if you're using php-fpm.
// https://stackoverflow.com/questions/4870697/php-flush-that-works-even-in-nginx <- best
// header('X-Accel-Buffering: no'); // will make it work without modifying nginx's settings

// also check:
// https://stackoverflow.com/questions/3133209/how-to-flush-output-after-each-echo-call/4763130#4763130
// https://stackoverflow.com/questions/12165810/how-to-disable-output-buffering-in-nginx-for-php-application
// especially detailed explanation for apache:
// https://stackoverflow.com/questions/8882383/how-to-disable-output-buffering-in-php

// these have no effect at least on nginx when I have set these same ini settings in php.ini
// ini_set("output_buffering", 0);
// ini_set('zlib.output_compression',0);
// ini_set('implicit_flush',1);
// @ob_end_clean();
// set_time_limit(0);


// Final for nginx:
// in /etc/nginx/nginx.conf these must be set (inside "http {...}" worked, gzip setting was already there):
// gzip off;
// fastcgi_buffering off;
// fastcgi_keep_conn on; # < solution
// proxy_buffering off;

// php code itself
for ($i = 0; $i < 5; $i++){
    // place the breakpoint on the next line (echo)
    echo $i . "<br>";
    // the sleep line should make it print line-by-line without debugger's interception
    // sleep(1); // sleep for 1 sec
}
phpinfo();