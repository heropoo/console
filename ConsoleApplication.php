<?php
/**
 * User: Heropoo
 * Date: 2019/3/16
 * Time: 23:51
 */

namespace Moon\Console;


class ConsoleApplication
{
    protected $script;
    protected $name;
    protected $version;

    public function __construct($script = 'moon', $name = 'Moon Console Application', $version = 'v0.1')
    {
        $this->script = $script;
        $this->name = $name;
        $this->version = $version;
    }

    public function handleCommand(Console $console)
    {
        $argv = $_SERVER['argv'];
        foreach ($argv as $key => $arg) {
            if ((strpos($arg, $this->script) + strlen($this->script)) == strlen($arg) || $arg === $this->script) {
                break;
            } else {
                unset($argv[$key]);
            }
        }
        if (!isset($argv[1])) {
            echo $this->name . ' ' . $this->version . PHP_EOL;
            echo '------------------------------------------------' . PHP_EOL;
            // command list
            ksort($console->commands);
            $max_length = 10;
            foreach ($console->commands as $command => $options) {
                $max_length = max($max_length, strlen($command));
            }
            foreach ($console->commands as $command => $options) {
                echo sprintf("%-{$max_length}s\t%s", $command, $options['description']).PHP_EOL;
            }
            return 0;
        }
        $command = $argv[1];
        unset($argv[0], $argv[1]);
        return $console->runCommand($command, $argv);
    }
}
