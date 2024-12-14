<?php

declare(strict_types=1);

use Hyperf\DbConnection\Db;

/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
ini_set('display_errors', 'on');
ini_set('display_startup_errors', 'on');

error_reporting(E_ALL);
date_default_timezone_set('Asia/Shanghai');

Swoole\Runtime::enableCoroutine(true);

! defined('BASE_PATH') && define('BASE_PATH', dirname(__DIR__, 1));

require BASE_PATH . '/vendor/autoload.php';

! defined('SWOOLE_HOOK_FLAGS') && define('SWOOLE_HOOK_FLAGS', Hyperf\Engine\DefaultOption::hookFlags());

Hyperf\Di\ClassLoader::init();

$container = require BASE_PATH . '/config/container.php';

$config = $container->get(\Hyperf\Contract\ConfigInterface::class);
$config->set('databases.default', $config->get('databases.test'));

$container->get(Hyperf\Contract\ApplicationInterface::class);

Swoole\Coroutine\run(function () use ($container) {
	Db::connection('test')->statement('DROP DATABASE IF EXISTS `payments-database-test`');
	Db::connection('test')->statement('CREATE DATABASE `payments-database-test` CHARACTER SET utf8 COLLATE utf8_general_ci');

	$container->get('Hyperf\Database\Commands\Migrations\MigrateCommand')->run(
		new Symfony\Component\Console\Input\StringInput(''),
		new Symfony\Component\Console\Output\ConsoleOutput()
	);
});
