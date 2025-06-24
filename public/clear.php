<?php
shell_exec('php artisan config:clear');
shell_exec('php artisan cache:clear');
shell_exec('php artisan view:clear');
echo "Cache cleared!";
