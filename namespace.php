<?php

namespace HTTP;
class Client {
    function result() {
        return "is a HTTP Client";
    }
}

namespace TWITTER;
class Client {
    function result() {
        return "is a TWITTER Client";
    }
}

$http = new \HTTP\Client;
$twitter = new \TWITTER\Client;

echo $http->result();
echo "<br />";
echo $twitter->result();
