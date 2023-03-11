<?php

define('SERVERS', [
    'HTTP/1' => [
        'ip' => 'localhost',
        'port' => 80,
        'status' => '<i class="fa fa-check-circle"></i> Up',
        'purpose' => '100.00%'
    ],
    'HTTPS/2' => [
        'ip' => 'localhost',
        'port' => 443,
        'status' => '<i class="fa fa-check-circle"></i> Up',
        'purpose' => '100.00%'
    ],
    'WEBMAIL' => [
        'ip' => 'localhost',
        'port' => 2096,
        'status' => '<i class="fa fa-check-circle"></i> Up',
        'purpose' => '100.00%'
    ],
    'SMTP' => [
        'ip' => 'localhost',
        'port' => 587,
        'status' => '<i class="fa fa-check-circle"></i> Up',
        'purpose' => '100.00%'
    ],
    'MYSQL' => [
        'ip' => 'localhost',
        'port' => 3306,
        'status' => '<i class="fa fa-times"></i> Major Outage',
        'purpose' => 'Error'
    ]
]);

if (isset($_GET['host'])) {
    $host = $_GET['host'];
    if (isset(SERVERS[$host])) {
        header('Content-Type: application/json');
        $status = test(SERVERS[$host]);
        $response = ['status' => $status];
        echo json_encode($response);
        exit;
    } else {
        header('HTTP/1.1 404 Not Found');
    }
}

$title = 'Uptime Server Status';
?>

<!doctype html>
<html lang="en">
    <head>
     <!-- Required meta tags -->
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="utf-8" http-equiv="encoding">
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <title><?php echo $title; ?></title>
     <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootswatch/2.3.2/cosmo/bootstrap.min.css">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css">
    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.6/css/all.css">
<style type="text/css">
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

html, body {
    height: 100%;
    width: 100%;
    font-family: sans-serif, 'trebuchet ms', 'lucida grande', 'lucida sans unicode', arial, helvetica, sans-serif;
}

a {
    outline: none;
}

input:focus, select:focus, textarea:focus, button:focus {
    outline: 0;
}

p {
    margin: 0;
}

img {
    border: 0;
}

h1, h2, h3 {
    margin: 0;
    padding: 0;
}

h2 {
    font-size: 1.5em;
    margin-bottom: 5px;
    line-height: 1.1;
}

ul, li {
    margin: 0;
    padding: 0;
    list-style: none;
}

button {
    border: none;
    outline: none;
    cursor: pointer;
}

table {
    table-layout: fixed;
}

html {
    background: url(//hdwallsource.com/img/2014/4/free-background-wallpaper-22918-23554-hd-wallpapers.jpg) fixed center / cover #222;
    color: #2e2f30;
}

.dialog {
    width: 98%;
    max-width: 500px;
    margin: 30vh auto 0;
}

.dialog > div {
    padding: 7px 10px 0;
    border: 1px solid #ccc;
    border-top: 4px solid #03add8;
    border-radius: 9px;
    background-color: #ccc;
    box-shadow: 0 3px 8px rgba(50,50,50,.17);
}

.dialog > div img {
    display: block;
    width: 90%;
    height: auto;
    margin: 0 auto;
}

.dialog > div h1 {
    font-size: 100%;
    line-height: 1.5;
    color: #730e15;
}

.dialog > p {
    margin: 0 0 1em;
    padding: 1em;
    color: #666;
    border: 1px solid #ccc;
    border-radius: 0 0 4px 4px;
    background-color: #f7f7f7;
    box-shadow: 0 3px 8px rgba(50,50,50,.17);
    border-color: #dadada #999 #999;
}

.container {
    width: 100%;
}

.logo {
    max-width: 50%;
}

.status_th {
    width: 40px;
}
</style>
    </head>
	
	  <div class="dialog">
    <div>
	  <img class="logo" src="//www.updownkc.com/wp-content/uploads/2013/11/updownblack.png" width="360" height="106">
      <h1><?php echo $title; ?></h1>
             <div class="container">         
            <table class="table">
                <thead>
                    <tr>
                        <th class="status_th"></th>
                        <th><i class="fas fa-globe"></i> Host</th>
                        <th><i class="fas fa-chart-bar"></i> Status</th>
                        <th><i class="fas fa-sync"></i> Uptime</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($servers as $name => $server): ?>

                        <tr id="<?php echo md5($name); ?>">
                            <td class="spin_icon"><i class="icon-spinner icon-spin icon-large"></i></td>
                            <td class="name"><?php echo $name; ?></td>
                            <td><?php echo $server['info']; ?></td>
                            <td><?php echo $server['purpose']; ?></td>
                        </tr>

                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </div>
    <p>Copyright © exemple.com. All rights reserved.</p>
  </div>
  
    <body>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    </body>

        <script type="text/javascript">
            function test(host, hash) {
                // Fork it
                var request;
                // fire off the request to /form.php
                request = $.ajax({
                    url: "<?php echo basename(__FILE__); ?>",
                    type: "get",
                    data: {
                        host: host
                    },
                    beforeSend: function() {
                        $('#' + hash + " .spin_icon").children().css({
                            'visibility': 'visible'
                        });
                    }
                });
                // callback handler that will be called on success
                request.done(function(response, textStatus, jqXHR) {
                    var status = response.status;
                    var statusClass;
                    if (status) {
                        statusClass = 'success';
                    } else {
                        statusClass = 'error';
                    }
                    $('#' + hash).removeClass('success error').addClass(statusClass);
                });
                // callback handler that will be called on failure
                request.fail(function(jqXHR, textStatus, errorThrown) {
                    // log the error to the console
                    console.error(
                        "The following error occured: " +
                        textStatus, errorThrown
                    );
                });
                request.always(function() {
                    $('#' + hash + " .spin_icon").children().css({
                        'visibility': 'hidden'
                    });
                })
            }
            $(document).ready(function() {
                var servers = <?php echo json_encode($names); ?>;
                var server, hash;
                for (var key in servers) {
                    server = key;
                    hash = servers[key];
                    test(server, hash);
                    (function loop(server, hash) {
                        setTimeout(function() {
                            test(server, hash);
                            loop(server, hash);
                        }, 6000);
                    })(server, hash);
                }
            });
        </script>

    </body>
</html>
<?php
/* Misc at the bottom */
function test($server) {
    $socket = @fsockopen($server['ip'], $server['port'], $errorNo, $errorStr, 3);
    if ($errorNo == 0) {
        return true;
    } else {
        return false;
    }
}
function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }
    return false;
}

?>
