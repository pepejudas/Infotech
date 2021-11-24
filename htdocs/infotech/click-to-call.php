<?php 
try{
$extension="101" ; //where 9999 is the extension you would like to call

 $socket = fsockopen("200.71.48.212","5038", $errno, $errstr, $timeout); 
 fputs($socket, "Action: Login\r\n"); 
 fputs($socket, "UserName: 102");     // default username and password for TrixBox users
 fputs($socket, "Secret: 123@456@");  // for other Asterisk platforms plase get your username and  
                                            // password from /etc/asterisk/manager.conf
              $wrets=fgets($socket,128); 
              echo $wrets;

               fputs($socket, "Action: Originate\r\n" ); 
               fputs($socket, "Channel: SIP/$extension\r\n" ); 
               fputs($socket, "Exten: $extension\r\n" ); 
               fputs($socket, "Context: outbound-dialing\r\n" ); 
               fputs($socket, "Priority: 1\r\n" ); 
               fputs($socket, "Async: yes\r\n\r\n" ); 

               $wrets=fgets($socket,128); 
               echo $wrets; 
}catch(Exception $error){
echo $error;
}
?> 
1032411181

