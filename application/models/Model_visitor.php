<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Model_visitor extends CI_Model {

	/**
	 * @return IP (192.168.1.1)
	 */
	function ip_user()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		return $ip;
	}

    function strleft($s1, $s2) { return substr($s1, 0, strpos($s1, $s2)); }

    function selfURL() { 
        $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
        $protocol = $this->strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s; 
        $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]); 
        return $protocol."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI']; 
    }

	/**
	 * @see http://php.net/manual/en/function.get-browser.php;
	 * @return 
	 */
	function browser_user()
	{
		$browser = $this->userAgent();
		return $browser['name'] . ' v.'.$browser['version'];
	}
	# User Agent
	function userAgent()
	{
		$u_agent 	= $_SERVER['HTTP_USER_AGENT']; 
		$bname   	= 'Unknown';
		$platform 	= 'Unknown';
		$version 	= "";

		$os_array       =   array(
								'/windows nt 10.0/i'    =>  'Windows 10',
                                '/windows nt 6.3/i'     =>  'Windows 8.1',
								'/windows nt 6.2/i'     =>  'Windows 8',
								'/windows nt 6.1/i'     =>  'Windows 7',
								'/windows nt 6.0/i'     =>  'Windows Vista',
								'/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
								'/windows nt 5.1/i'     =>  'Windows XP',
								'/windows xp/i'         =>  'Windows XP',
								'/windows nt 5.0/i'     =>  'Windows 2000',
								'/windows me/i'         =>  'Windows ME',
								'/win98/i'              =>  'Windows 98',
								'/win95/i'              =>  'Windows 95',
								'/win16/i'              =>  'Windows 3.11',
								'/macintosh|mac os x/i' =>  'Mac OS X',
								'/mac_powerpc/i'        =>  'Mac OS 9',
								'/linux/i'              =>  'Linux',
								'/ubuntu/i'             =>  'Ubuntu',
								'/iphone/i'             =>  'iPhone',
								'/ipod/i'               =>  'iPod',
								'/ipad/i'               =>  'iPad',
								'/android/i'            =>  'Android',
								'/blackberry/i'         =>  'BlackBerry',
								'/webos/i'              =>  'Mobile'
							);

		foreach ($os_array as $regex => $value) { 

			if (preg_match($regex, $u_agent)) {
				$platform    =   $value;
			}

		}
		// Next get the name of the useragent yes seperately and for good reason
		if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
		{ 
			$bname = 'Internet Explorer'; 
			$ub = "MSIE"; 
		} 
		elseif(preg_match('/Firefox/i',$u_agent)) 
		{ 
			$bname = 'Mozilla Firefox'; 
			$ub = "Firefox"; 
		} 
		elseif(preg_match('/Chrome/i',$u_agent)) 
		{ 
			$bname = 'Google Chrome'; 
			$ub = "Chrome"; 
		} 
		elseif(preg_match('/Safari/i',$u_agent)) 
		{ 
			$bname = 'Apple Safari'; 
			$ub = "Safari"; 
		} 
		elseif(preg_match('/Opera/i',$u_agent)) 
		{ 
			$bname = 'Opera'; 
			$ub = "Opera"; 
		} 
		elseif(preg_match('/Netscape/i',$u_agent)) 
		{ 
			$bname = 'Netscape'; 
			$ub = "Netscape"; 
		} 
	   
		// finally get the correct version number
		$known = array('Version', $ub, 'other');
		$pattern = '#(?<browser>' . join('|', $known) .
		')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
		if (!preg_match_all($pattern, $u_agent, $matches)) {
			// we have no matching number just continue
		}
		
		// see how many we have
		$i = count($matches['browser']);
		if ($i != 1) {
			//we will have two since we are not using 'other' argument yet
			//see if version is before or after the name
			if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
				$version= $matches['version'][0];
			}
			else {
				$version= $matches['version'][1];
			}
		}
		else {
			$version= $matches['version'][0];
		}
		
		// check if we have a number
		if ($version==null || $version=="") {$version="?";}
		
		return array(
			'userAgent' => $u_agent,
			'name'      => $bname,
			'version'   => $version,
			'platform'  => $platform,
			'pattern'   => $pattern
		);
	}

	/**
	 * @return name Operating System*/
	function os_user()
	{
		$OS = $this->userAgent();
		return $OS['platform'];
	}

    function start_tracking_visitors(){
        $time = time();
        if (!isset($_COOKIE['VISITOR'])) {
            $this->db->where("visitor_ip",$this->ip_user());
            $this->db->where("duration >",$time);
            $this->db->where("visitor_page =",$this->selfURL());
            $table = $this->db->get("visitors_table");
            if($table->num_rows()>0){
				$duration = time()+60*60;
				$browser = $this->browser_user();
				setcookie('VISITOR',$browser,$duration);
            }else{
                $this->send_visitors();
            }
        }else{
            
        }
    }

	function send_visitors()
	{
		// rekam data user yang sudah mengakses website kita
		$ip      = $this->ip_user();
		$browser = $this->browser_user();
		$os      = $this->os_user();
        $ref = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        $visitor_refferer = GetHostByName($ref);

		// Check bila sebelumnya data pengunjung sudah terrekam
		

			// Masa akan direkam kembali
			// Tujuan untuk menghindari merekam pengunjung yang sama dihari yang sama.
			// Cookie akan disimpan selama 24 jam
			$duration = time()+60*60;

			// simpan kedalam cookie browser
			setcookie('VISITOR',$browser,$duration);

            $visitor_ip = $ip;
            $visitor_browser = $browser;
            $visitor_hour = date("H");
            $visitor_minute = date("i");
            $visitor_day = date("d");
            $visitor_month = date("m");
            $visitor_year = date("Y");
            $ref = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
            $visitor_refferer = GetHostByName($ref);
            $visited_page = $this->selfURL();
            $visitor_date = date("Y-m-d H:i:s");

            //write the required data to database
            $sql = "INSERT INTO visitors_table (visitor_ip, visitor_browser, visitor_hour,
            visitor_minute, visitor_date, visitor_day, visitor_month, visitor_year, 
            visitor_refferer, visitor_page, os, duration) VALUES ('$visitor_ip', '$visitor_browser', 
            '$visitor_hour', '$visitor_minute', '$visitor_date', '$visitor_day', '$visitor_month', 
            '$visitor_year', '$visitor_refferer', '$visited_page', '$os', '$duration')";

			$this->db->query($sql);
		
	}

}
 
/* End of file Auth_model.php */
/* Location: ./application/models/Auth_model.php */