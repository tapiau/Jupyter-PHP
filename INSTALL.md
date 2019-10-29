
composer init --no-interaction  --name=tapiau/jupyter-php-instance  --type=project --require=tapiau/jupyter-php=dev-master
composer config repositories.project vcs https://github.com/tapiau/Jupyter-PHP.git
composer install  --no-interaction  --no-progress  --prefer-dist  --optimize-autoloader  

--working-dir=path
