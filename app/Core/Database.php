<?php

namespace App\Core;

use mysqli;
use mysqli_stmt;

class Database
{
    /**
     * @var Database|null $instance
     */
    private static ?Database $instance = null;

    /**
     * @var mysqli $connection
     */
    protected mysqli $connection;

    /**
     * @var mysqli_stmt|bool $query
     */
    protected mysqli_stmt|bool $query;

    /**
     * @var bool $show_errors
     */
    protected bool $show_errors = true;

    /**
     * @var bool $query_closed
     */
    protected bool $query_closed = true;

    /**
     * @var int $query_count
     */
    public int $query_count = 0;

    // The constructor is private
    // to prevent initiation with outer code.
    // todo refactor DB Class
    private function __construct(
        string $db_host = 'localhost',
        string $db_user = 'root',
        string $db_pass = '',
        string $db_name = ''
    )
    {
        $this->connection = new mysqli($db_host, $db_user, $db_pass, $db_name);

        if ($this->connection->connect_error) {
            $this->error('Failed to connect to MySQL - ' . $this->connection->connect_error);
        }

        $this->connection->set_charset('utf8');
    }

    // The object is created from within the class itself
    // only if the class has no instance.
    public static function getInstance(): ?Database
    {
        if (self::$instance === null)
        {
            $db_host = config('database.host');
            $db_user = config('database.user');
            $db_pass = config('database.password');
            $db_name = config('database.name');

            self::$instance = new Database($db_host, $db_user, $db_pass, $db_name);
        }

        return self::$instance;
    }

    /**
     * @param $query
     * @return $this
     */
    public function query($query): Database
    {
        if (!$this->query_closed) {
            $this->query->close();
        }

        if ($this->query = $this->connection->prepare($query)) {
            if (func_num_args() > 1) {
                $x = func_get_args();
                $args = array_slice($x, 1);
                $types = '';
                $args_ref = array();

                foreach ($args as $k => &$arg) {
                    if (is_array($args[$k])) {
                        foreach ($args[$k] as $j => &$a) {
                            $types .= $this->_gettype($args[$k][$j]);
                            $args_ref[] = &$a;
                        }
                        unset($a);
                    } else {
                        $types .= $this->_gettype($args[$k]);
                        $args_ref[] = &$arg;
                    }
                }
                unset($arg);

                array_unshift($args_ref, $types);
                call_user_func_array(array($this->query, 'bind_param'), $args_ref);
            }

            $this->query->execute();

            if ($this->query->errno) {
                $this->error('Unable to process MySQL query (check your params) - ' . $this->query->error);
            }

            $this->query_closed = false;
            $this->query_count++;
        } else {
            $this->error('Unable to prepare MySQL statement (check your syntax) - ' . $this->connection->error);
        }

        return $this;
    }

    /**
     * @param $callback
     * @return array
     */
    public function fetchAll($callback = null): array
    {
        $params = array();
        $row = array();
        $meta = $this->query->result_metadata();

        while ($field = $meta->fetch_field()) {
            $params[] = &$row[$field->name];
        }

        call_user_func_array(array($this->query, 'bind_result'), $params);

        $result = array();

        while ($this->query->fetch()) {
            $r = array();

            foreach ($row as $key => $val) {
                $r[$key] = $val;
            }

            if ($callback !== null && is_callable($callback)) {
                $value = $callback($r);

                if ($value === 'break') {
                    break;
                }
            } else {
                $result[] = $r;
            }
        }

        $this->query->close();
        $this->query_closed = true;

        return $result;
    }

    public function fetchArray(): array
    {
        $params = array();
        $row = array();
        $meta = $this->query->result_metadata();

        while ($field = $meta->fetch_field()) {
            $params[] = &$row[$field->name];
        }

        call_user_func_array(array($this->query, 'bind_result'), $params);

        $result = array();

        while ($this->query->fetch()) {
            foreach ($row as $key => $val) {
                $result[$key] = $val;
            }
        }

        $this->query->close();
        $this->query_closed = true;

        return $result;
    }

    /**
     * @return bool
     */
    public function close(): bool
    {
        return $this->connection->close();
    }

    /**
     * @return mixed
     */
    public function numRows() {
        $this->query->store_result();

        return $this->query->num_rows;
    }

    /**
     * @return mixed
     */
    public function affectedRows() {
        return $this->query->affected_rows;
    }

    /**
     * @return mixed
     */
    public function lastInsertID() {
        return $this->connection->insert_id;
    }

    /**
     * @param $error
     * @return void
     */
    public function error($error): void
    {
        if ($this->show_errors) {
            exit($error);
        }
    }

    /**
     * @param $var
     * @return string
     */
    private function _gettype($var): string
    {
        if (is_string($var)) {
            return 's';
        }

        if (is_float($var)) {
            return 'd';
        }

        if (is_int($var)) {
            return 'i';
        }

        return 'b';
    }
}