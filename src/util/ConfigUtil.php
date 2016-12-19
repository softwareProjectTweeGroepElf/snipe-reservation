<?php
// Created by lupix. All rights reserved.

namespace sp2gr11\reservation\util;


use Illuminate\Database\Connection;

class ConfigUtil
{
    private $connection;
    private $config;
    protected $table = 'reservation_config';

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function initConfig()
    {
        $this->config = array_map(function ($a) {
            $result = array();
            foreach($a as $option => $value)
            {
                if(!strpos('_DESCRIPTION', $option))
                    $result[$option] = $value;
            }

            return $result;
        }, config('reservation'));


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

    public function getParsedConfig()
    {
        $parsed_config = array();
        foreach($this->config as $option => $value)
        {
            if(is_array($value))
                $parsed_config[$option] = implode(',', $value);
            else
                $parsed_config[$option] = $value;
        }

        return $parsed_config;
    }

    public function option($option)
    {
        return $this->config[$option];
    }

    public function defaultOption($option)
    {
        return config('reservation.' . $option);
    }

    public function getDescription($option)
    {
        return config($option . '_DESCRIPTION');
    }

    public function write(array $options_values)
    {
        foreach($options_values as $option => $value)
        {
            if($this->connection->table($this->table)->where('option', $option)->count() > 0)
                $this->connection->table($this->table)->where('option', $option)->update(['value' => is_array($value) ? json_encode($value) : $value]);
            else
                $this->connection->table($this->table)->insert(['option' => $option, 'value' => is_array($value) ? json_encode($value) : $value]);
        }
    }
    
    private function retrieveUserConfig()
    {
        if ($this->connection->table($this->table)->count() == 0)
            return false;

        $raw_config = $this->connection->table($this->table)->get();
        $user_config = array();

        foreach($raw_config as $option)
            $user_config[$option->option] = json_decode($option->value);

        return $user_config;
    }
}