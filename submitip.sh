machine=$(hostname)
ip=$(lynx --dump http://ipecho.net/plain)	# Bit shit
ip=$(echo $ip | tr -d " ")
url="http://www.ajrobinson.org/ip.php?machine=${machine}&ip=${ip}"

echo "   Dumping: $url"
echo 

lynx --dump ${url}
