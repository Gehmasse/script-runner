<?php

namespace App;

class App
{
    public function __construct(private array $argv)
    {
    }

    /**
     * name => [path, file, defaultParam, prefix]
     */
    public function scripts() : array
    {
        return require __DIR__ . '/../scripts.php';
    }

    public function script() : ?string
    {
        return $this->argv[1] ?? null;
    }

    public function args(string $defaultArgs, string $prefix) : array
    {
        $args = array_slice($this->argv, 2);

        return $args === null || count($args) === 0 ? [$defaultArgs] : [$prefix . $args[0], ...array_slice($args, 1)];
    }

    public function maxNameLength() : int
    {
        return max(array_map(fn(string $name) => strlen($name), array_keys($this->scripts())));
    }

    public function list() : string
    {
        $res = '';

        foreach($this->scripts() as $name => [$path, $file]) {
            $res .= str_repeat(' ',  $this->maxNameLength() - strlen($name)) . $name . ': ' . $path . '/' . $file . PHP_EOL;
        }

        return $res;
    }

    public function run() : void
    {
        if(!array_key_exists($this->script(), $this->scripts())) {
            die('script ' . $this->script() . ' does not exist' . PHP_EOL);
        }

        [$path, $file, $defaultArgs, $prefix] = $this->scripts()[$this->script()];

        while (@ob_end_flush()); // end all output buffers if any

        $cmd = 'cd ' . self::DEV_DIR . '/' . $path . ' && php ' . $file . ' ' . join(' ', $this->args($defaultArgs, $prefix));

        $proc = popen($cmd, 'r');

        while (!feof($proc)){
            echo fread($proc, 4096);
            @flush();
        }
    }
}
