<?php

use Symfony\Component\Console\Output\OutputInterface;
$container = require __DIR__ . '/app/bootstrap.php';

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

$app = new Silly\Application();
$app->useContainer($container, $injectWithTypeHint = true);

$app->command('app:spotify_change_proxy [filename]', function (OutputInterface $output, \Service\Spotify\SpotifyManager $spotifyManager, $filename) {
    if(!file_exists($filename)){
        $output->writeln('<comment>File not exists</comment>');
    }else{
        try{
            $spotifyManager->changeProxy($filename);
        }catch (\Service\Proxy\ProxyException $exception){
            $output->writeln('<comment>Proxy not exists</comment>');
        }
    }
})->defaults([
    'filename'=> '/home/prog12/.config/spotify/prefs'
]);

$app->run();
