<?php
Session_start();
Session_unset();
Session_destroy();
Header("Location: login.php");
Exit;