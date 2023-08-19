<?php

$servers = [
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
];

if (isset($_GET['host'])) {
    $host = $_GET['host'];
    if (isset($servers[$host])) {
        header('Content-Type: application/json');
        $status = test($servers[$host]);
        $response = ['status' => $status];
        echo json_encode($response);
        exit;
    } else {
        header('HTTP/1.1 404 Not Found');
    }
}

$title = 'Uptime Server Status';
$names = array_keys($servers);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootswatch/2.3.2/cosmo/bootstrap.min.css">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css">
    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.6/css/all.css">
    <style type="text/css">
        /* Your CSS styles here */
    </style>
</head>
<body>
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
                        <td><?php echo $server['status']; ?></td>
                        <td><?php echo $server['purpose']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <p>Copyright © example.com. All rights reserved.</p>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript">
        // Your JavaScript code here
    </script>
</body>
</html>
<?php

/* Function to test server status */
function test($server) {
    $socket = @fsockopen($server['ip'], $server['port'], $errorNo, $errorStr, 3);
    if ($errorNo == 0) {
        return true;
    } else {
        return false;
    }
}

/* Recursive in_array function */
function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }
    return false;
}
?>
