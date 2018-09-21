<?php

//Load configuration
function config_load()
{
    return parse_ini_file('/var/www/config.ini');
}


//Get clients ip
function ip()
{
    return $_SERVER['REMOTE_ADDR'];
}

//Get current date (and time)
function current_date($andTime = false)
{
    if ($andTime) {
        return date('Y-m-d H:i:s');
    } else {
        return date('Y-m-d');
    }
}


//Log actions
function log_action($user, $action, $priority)
{
    $date = current_date(true);
    $ip = ip();
    $query = "INSERT INTO logs (date, user, action, ip, priority) VALUES ('{$date}', '{$user}', '{$action}', '{$ip}', '{$priority}')";
    sql_query($query, false);
}


//Redirect and set alert if specified
function redirect($to, $alert = null)
{
    !isset($alert) ?: alert_set($alert);
    header('location: ' . $to);
    exit;
}


//Alert system
function alert_set($alert)
{
    $_SESSION['alert'] = $alert;
}

function alert_display()
{
    if (isset($_SESSION['alert']) && !empty($_SESSION['alert'])) {
        echo "<script>M.toast({html: '{$_SESSION['alert']}'})</script>";
        unset($_SESSION['alert']);
    }
}

function agenda()
{
    $query =
        "SELECT
            title,
            link,
            date
        FROM
            agenda
        WHERE
            DATE(date) >= DATE(NOW())";

    $items = sql_query($query, false);

    if ($items->num_rows > 0) {
        while ($item = $items->fetch_assoc()) {
            echo <<<END
            <div class="col s12 m6 l4 xl4">
                <div class="card">
                    <div class="card-content">
                      <span class="card-title">{$item['title']}</span>
                      <p>{$item['date']}</p>
                    </div>
                    <div class="card-action">
                        <a href="{$item['link']}" target="_blank">Link</a>
                    </div>
                </div>
            </div>
END;
        }
    } else {
        echo '<p>Er zijn op dit moment geen agenda items.</p> ';
    }
}
