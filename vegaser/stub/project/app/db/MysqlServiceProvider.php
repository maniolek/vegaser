<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawomir.zytko@gmail.com>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage http://vegas-cmf.github.io
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Phalcon\DiInterface;
use Vegas\DI\ServiceProviderInterface;

class DbServiceProvider implements ServiceProviderInterface
{
    const SERVICE_NAME = 'db';

    /**
     * {@inheritdoc}
     * @see http://docs.phalconphp.com/en/latest/api/Phalcon_Db_Adapter_Pdo_Mysql.html
     */
    public function register(DiInterface $di)
    {
        $di->set(self::SERVICE_NAME, function () use ($di) {
            $config = $di->get('config');
            return new Phalcon\Db\Adapter\Pdo\Mysql([
                "host" => $config->db->hostname,
                "dbname" => $config->db->dbname,
                "port" => $config->db->port,
                "username" => $config->db->username,
                "password" => $config->db->password,
                "options" => [
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
                ]
            ]);
        }, true);
    }

    /**
     * {@inheritdoc}
     */
    public function getDependencies()
    {
        return [
            ModelsManagerServiceProvider::SERVICE_NAME
        ];
    }
} 