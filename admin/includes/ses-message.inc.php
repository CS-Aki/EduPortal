<?php

function displaySessionMessage($session, $ch)
{

    switch ($ch) {
        case 1:
            if (isset($_SESSION[$session])) {
                echo $_SESSION[$session];
                unset($_SESSION[$session]);
                break;
            }
        case 2:
            if (isset($_SESSION[$session])) {
                echo $_SESSION[$session];
                return '';
            }
            break;
    }
}
