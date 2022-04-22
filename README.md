# demo-cms-v2
- Laravel Admin template built from Laravel9, Vue3, Inertia & Tailwind
- User Role-based access control (RBAC)
- Docker env (laradock)

setup:
- clone this code
- cd to folder laradock
- run this command "docker-compose up -d mysql nginx php-fpm redis workspace phpmyadmin"
- once container is up, ssh to workspace by command "docker exec -it example_cms-workspace-1 bash"
- run command "php artisan migrate:fresh --seed"
- run command "php artisan serve"
- open browser and visit http://example-cms.test

Please rate if you feel it helpful. Many thanks. Have fun ;) 

*note: I'm using Macos (mac chip), if you're using window, maybe have some conflict.
My code maybe not optimize, please give me feedback if there any things you want improve. Thanks
