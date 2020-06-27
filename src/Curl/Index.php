<?php declare(strict_types = 1);

namespace Curl;

/**
 * curl --header "X-MyHeader: 123" www.google.com
 */

class Index
{
    public function curl()
    {
    }
}

/*
 *```
# create a cURL handle
$ch = curl_init();
# set the URL (this could also be passed to curl_init() if desired)
curl_setopt($ch, CURLOPT_URL, "https://www.example.com/login.php");
# set the HTTP method to POST
curl_setopt($ch, CURLOPT_POST, true);
# setting this option to an empty string enables cookie handling
# but does not load cookies from a file
curl_setopt($ch, CURLOPT_COOKIEFILE, "");
# set the values to be sent
curl_setopt($ch, CURLOPT_POSTFIELDS, array(
"username"=>"joe_bloggs",
"password"=>"$up3r_$3cr3t",
));
```


```
# return the response body
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
# send the request
$result = curl_exec($ch);
GoalKicker.com – PHP Notes for Professionals 192
The second step (after standard error checking is done) is usually a simple GET request. The important thing is to
reuse the existing cURL handle for the second request. This ensures the cookies from the first response will be
automatically included in the second request.
# we are not calling curl_init()
# simply change the URL
curl_setopt($ch, CURLOPT_URL, "https://www.example.com/show_me_the_foo.php");
# change the method back to GET
curl_setopt($ch, CURLOPT_HTTPGET, true);
# send the request
$result = curl_exec($ch);
# finished with cURL
curl_close($ch);
# do stuff with $result...
```

```
$ch = curl_init();
curl_setopt_array($ch, array(
CURLOPT_POST => 1,
CURLOPT_URL => "https://api.externalserver.com/upload.php",
CURLOPT_RETURNTRANSFER => 1,
CURLINFO_HEADER_OUT => 1,
CURLOPT_POSTFIELDS => $data
));
$result = curl_exec($ch);
curl_close ($ch);
```

```
#request
$method = 'DELETE'; // Create a DELETE request
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
$content = curl_exec($ch);
curl_close($ch);
```

```
Sending The Request Header
$uri = 'http://localhost/http.php';
$ch = curl_init($uri);
curl_setopt_array($ch, array(
CURLOPT_HTTPHEADER => array('X-User: admin', 'X-Authorization: 123456'),
CURLOPT_RETURNTRANSFER =>true,
CURLOPT_VERBOSE => 1
));
$out = curl_exec($ch);
curl_close($ch);
// echo response output
echo $out;
```
 */
