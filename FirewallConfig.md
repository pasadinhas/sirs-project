##1 - Configure nginx to limit rquests in burst

	###go to nginx.conf and on http {...}
	####write:
	
		limit_req_zone $binary_remote_addr zone=one:10m rate=10r/s;
		limit_req_status 444;
	
	
	###go to /etc/nginx/sites-available/wonder-shuttle
	####write on all locations:
	
		limit_req   zone=one  burst=5 nodelay;

##2 - Configure fail2ban to monitor nginx logs and ban repeating offenders

	###sudo nano /etc/fail2ban/filter.d/nginx-req-limit.conf
	####write:
	
		[Definition]

		failregex = limiting requests, excess:.* by zone.*client: <HOST>
		ignoreregex =

	###sudo cp /etc/fail2ban/jail.conf /etc/fail2ban/jail.local

	###sudo nano /etc/fail2ban/jail.local
	####write:

	  	[nginx-req-limit]
	  
	  	enabled = true
	  	filter = nginx-req-limit
	  	action = iptables-multiport[name=ReqLimit, port="http,https", protocol=tcp]
	  	logpath = /var/log/nginx/*error.log
	  	findtime = 60
	  	bantime = 7200
	  	maxretry = 300
