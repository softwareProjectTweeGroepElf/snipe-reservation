<?php
// Created by lupix. All rights reserved.

namespace sp2gr11\reservation\util;


use Illuminate\Database\Connection;

class ConfigUtil
{
    private $connection;
    private $config;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function initConfig()
    {
        if (!$this->config) {
            $this->config = config('reservation');
        }

        $user_config = $this->retrieveUserConfig();
        if ($user_config) {
            foreach ($user_config as $option => $value) {
                $this->config[$option] = $value;
            }
        }
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function option($option)
    {
        return $this->config[$option];
    }

    public function write(array $options_values)
    {
        foreach($options_values as $option => $value)
        {
            $this->connection->table('reservation_config')->where('option', $option)->update(['value' => is_array($value) ? json_encode($value) : $value]);
        }
    }

    private function retrieveUserConfig()
    {
        if ($this->connection->table('reservation_config')->count() == 0)
            return false;

        $raw_config = $this->connection->table('reservation_config')->get();
        $user_config = array();

        foreach($raw_config as $option)
            $user_config[$option->option] = json_decode($option->value);

        return $user_config;
    }
}