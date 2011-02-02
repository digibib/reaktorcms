#!/bin/bash
# wget ftp://ftp.joedog.org/pub/siege/siege-2.67.tar.gz && tar zxf siege-2.67.tar.gz && cd siege-2.67 && ./configure && make
# make install
#
# siege --help
#
# -C, --config            CONFIGURATION, show the current configuration.
# -v, --verbose           VERBOSE, prints notification to screen.
# -c, --concurrent=NUM    CONCURRENT users, default is 10
# -i, --internet          INTERNET user simulation, hits the URLs randomly.
#
# -t, --time=NUMm         TIME based testing where "m" is the modifier S, M, or H
#                         no space between NUM and "m", ex: --time=1H, one hour test.
#
# -r, --reps=NUM          REPS, number of times to run the test, default is 25
# -f, --file=FILE         FILE, change the configuration file to file.
# -R, --rc=FILE           RC, change the siegerc file to file.  Overrides
#                         the SIEGERC environmental variable.
# -l, --log               LOG, logs the transaction to PREFIX/var/siege.log
#
# -d, --delay=NUM         Time DELAY, random delay between 1 and num designed
#                         to simulate human activity. Default value is 3

#config=config-default.txt
config=config-nologin.txt

# www.minreaktor.no = 171.23.133.229
#host='171.23.133.229'
#host='www.minreaktor.no'
host='localhost'

#url="http://$host"
url="-i -f urls-no-login.txt"

dir="$host-$(date '+%Y-%m-%d_%H.%M.%S')"

#log="$PWD/$dir-c${num_users}t${time}-reaktor.log"
log="$PWD/$dir-reaktor.log"

#cmd_siege=siege
cmd_siege='/home/linpro/siege/siege-2.67/src/siege'
cmd_ps='ps -o pid,user=USERNAME -o nlwp=THR -o pri,nice=NICE -o vsz=SIZE -o rss=RES -o s=STATE -o time,pcpu=CPU -o args'

#$cmd_siege -R $config -C 2>&1|tee -a $log
$cmd_siege -R $config -C 1>>$log 2>&1

# Increasing users -------------------------------------------------------------
delay=5
Users[1]=10;Time[1]=1M;Delay[1]=$delay
Users[2]=20;Time[2]=1M;Delay[2]=$delay
Users[3]=30;Time[3]=1M;Delay[3]=$delay
Users[4]=40;Time[4]=1M;Delay[4]=$delay
Users[5]=50;Time[5]=1M;Delay[5]=$delay
Users[6]=60;Time[6]=1M;Delay[6]=$delay
Users[7]=70;Time[7]=1M;Delay[7]=$delay
Users[8]=80;Time[8]=1M;Delay[8]=$delay
Users[9]=90;Time[9]=1M;Delay[9]=$delay
Users[10]=100;Time[10]=1M;Delay[10]=$delay
Users[11]=110;Time[11]=1M;Delay[11]=$delay


# Different delays -------------------------------------------------------------
#users=20
#Users[1]=$users;Time[1]=1M;Delay[1]=7
#Users[2]=$users;Time[2]=1M;Delay[2]=5
#Users[3]=$users;Time[3]=1M;Delay[3]=3
#Users[4]=$users;Time[4]=1M;Delay[4]=5
#Users[5]=$users;Time[5]=1M;Delay[5]=4
#Users[6]=$users;Time[6]=1M;Delay[6]=3


pid="$$"
(while ps -p $pid >/dev/null 2>/dev/null; do echo && $cmd_ps -p $pid && uptime && free -o && sleep 10; done) 2>&1|tee -a $log &

#free -o -s 10 -c 37&
for index in 1 2 3 4 5 6 7; do
    echo '--------------------------------------------------------------------------------' 2>&1|tee -a $log
    #uptime 2>&1|tee -a $log
    #command="$cmd_siege -R $config -c ${Users[index]} -t ${Time[index]} -d ${Delay[index]} -l $log $url"
    command="$cmd_siege -R $config -c ${Users[index]} -t ${Time[index]} -d ${Delay[index]} -v -i -f urls-no-login.txt"
    #echo $command 2>&1|tee -a $log
    echo $command 1>>$log 2>&1
    #$command 2>&1|tee -a $log
    $command 1>>$log 2>&1
    #uptime 2>&1|tee -a $log
done

