<?php

use Illuminate\Container\Container;

/*
 * Define the ~/.valet path as a constant.
 */
if (isset($_SERVER['SUDO_USER'])) {
    define('VALET_HOME_PATH', '/home/'.$_SERVER['SUDO_USER'].'/.valet');
} else {
    define('VALET_HOME_PATH', $_SERVER['HOME'].'/.valet');
}

/*
 * Output the given text to the console.
 *
 * @param string $output
 *
 * @return void
 */
 if (!function_exists('info')) {
     function info($output)
     {
         output('<info>'.$output.'</info>');
     }
 }

/*
 * Output the given text to the console.
 *
 * @param string $output
 *
 * @return void
 */
 if (!function_exists('warning')) {
     function warning($output)
     {
         output('<fg=red>'.$output.'</>');
     }
 }

/*
 * Output the given text to the console.
 *
 * @param string $output
 *
 * @return void
 */
 if (!function_exists('output')) {
     function output($output)
     {
         if (isset($_ENV['APP_ENV']) && $_ENV['APP_ENV'] === 'testing') {
             return;
         }

         (new Symfony\Component\Console\Output\ConsoleOutput())->writeln($output);
     }
 }
/*
 * Resolve the given class from the container.
 *
 * @param string $class
 *
 * @return mixed
 */
 if (!function_exists('resolve')) {
     function resolve($class)
     {
         return Container::getInstance()->make($class);
     }
 }

/*
 * Swap the given class implementation in the container.
 *
 * @param string $class
 * @param mixed  $instance
 *
 * @return void
 */
 if (!function_exists('swap')) {
     function swap($class, $instance)
     {
         Container::getInstance()->instance($class, $instance);
     }
 }
/*
 * Retry the given function N times.
 *
 * @param int      $retries
 * @param callable $retries
 * @param int      $sleep
 *
 * @return mixed
 */
 if (!function_exists('retry')) {
     function retry($retries, $fn, $sleep = 0)
     {
         beginning:
    try {
        return $fn();
    } catch (Exception $e) {
        if (!$retries) {
            throw $e;
        }

        $retries--;

        if ($sleep > 0) {
            usleep($sleep * 1000);
        }

        goto beginning;
    }
     }
 }

/*
 * Verify that the script is currently running as "sudo".
 *
 * @return void
 */
 if (!function_exists('should_be_sudo')) {
     function should_be_sudo()
     {
         if (!isset($_SERVER['SUDO_USER'])) {
             throw new Exception('This command must be run with sudo.');
         }
     }
 }

/*
 * Tap the given value.
 *
 * @param mixed $value
 * @param callable $callback
 *
 * @return mixed
 */
if (!function_exists('tap')) {
    /*
     * Tap the given value.
     *
     * @param mixed $value
     * @param callable $callback
     *
     * @return mixed
     */
    function tap($value, callable $callback)
    {
        $callback($value);

        return $value;
    }
}

/*
 * Get the user.
 */
 if (!function_exists('user')) {
     function user()
     {
         if (!isset($_SERVER['SUDO_USER'])) {
             return $_SERVER['USER'];
         }

         return $_SERVER['SUDO_USER'];
     }
 }
