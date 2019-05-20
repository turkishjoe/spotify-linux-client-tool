#Spotify tool

Build based on https://github.com/php-di/demo

Tool for auto-changing proxy on linux spotify client

Usage:
1. composer install
2. cp .env.dist .env
3. Get you account at https://best-proxies.ru/ and fill BEST_PROXY_API_KEY.
You can implement ProxyProviderInterface and change it on app/config.php
4. php console.php app:spotify_change_proxy [filename] 
filename=/home/prog12/.config/spotify/prefs by default