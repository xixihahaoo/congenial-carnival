#!/bin/bash
int=1;
while(( int <= 5 ));
do
        /www/server/php/56/bin/php /www/wwwroot/www.28hxyct.xyz/cli.php login/crontab/opt_deal_status;
        /www/server/php/56/bin/php /www/wwwroot/www.28hxyct.xyz/cli.php login/crontab/auto_commission;
        /www/server/php/56/bin/php /www/wwwroot/www.28hxyct.xyz/cli.php login/crontab/auto_upgrade;
        let "int++";
        sleep 13;
done
