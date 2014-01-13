<?php

shell_exec("> ../deploy/logs/deploy.log");
shell_exec("../deploy/deploy.sh > ../deploy/logs/deploy.log");
echo("OK");
