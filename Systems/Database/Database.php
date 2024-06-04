<?php

    namespace Phreme\Systems\Database;

    defined("PHREME") OR exit("Forbidden Access");

    class Database {

        protected $DBconnection;
        protected $DBmysqli;

        public $cacheQuery = false;
        public $cacheSelect = false;
        public $cacheFrom = false;
        public $cacheWhere = false;
        public $cacheOrderBy = false;
        public $cacheLimit = false;
        public $cacheJoin = false;

        public function __construct(){
            $this->DBconnection = new \Phreme\Systems\Database\Connection();

            if ($this->DBconnection->connection()->connect_error) {
                throw new \Exception("Database connection failed [". $this->DBconnection->connection()->connect_errno ."] " . $this->DBconnection->connection()->connect_error);
            }

            $this->DBmysqli = $this->DBconnection->connection();
        }

        /**
         * Sets the SELECT part of the SQL query.
         *
         * @param  mixed $columns - Columns to be selected.
         * @return $this
         */
        public function select(mixed $columns): mixed {
            $select = "SELECT " . $this->sanitizeIdentifier($columns);
            $this->cacheSelect = $select;
            return $this;
        }

        /**
         * Sets the FROM part of the SQL query.
         *
         * @param  string $table - Table name.
         * @return $this
         */
        public function from(string $table): mixed {
            if ($this->cacheSelect) {
                $from = $this->cacheSelect . " FROM " . $this->sanitizeIdentifier($table);
                $this->cacheFrom = $from;
            } else {
                throw new \Exception("Select statement is not initialized.");
            }
            return $this;
        }

        /**
         * Sets the WHERE part of the SQL query.
         *
         * @param  mixed $condition - Condition for the WHERE clause.
         * @return $this
         */
        public function where(mixed $condition): mixed {
            $this->cacheWhere = " WHERE " . $this->buildCondition($condition);
            return $this;
        }

        /**
         * Sets the WHERE IN part of the SQL query.
         *
         * @param  mixed $column - Column name.
         * @param  mixed $values - Array of values.
         * @return $this
         */
        public function whereIn(mixed $column, mixed $values): mixed {
            $escapedValues = array_map([$this->DBmysqli, 'real_escape_string'], $values);
            $this->cacheWhere = " WHERE " . $this->sanitizeIdentifier($column) . " IN ('" . implode("', '", $escapedValues) . "')";
            return $this;
        }

        /**
         * Sets the WHERE NOT part of the SQL query.
         *
         * @param  mixed $condition - Condition for the WHERE NOT clause.
         * @return $this
         */
        public function whereNot(mixed $condition): mixed {
            $this->cacheWhere = " WHERE NOT " . $this->buildCondition($condition);
            return $this;
        }

        /**
         * Sets the ORDER BY part of the SQL query.
         *
         * @param  mixed $order - Order condition.
         * @return $this
         */
        public function orderBy(mixed $order): mixed {
            if (is_array($order)) {
                $order = implode(', ', array_map([$this, 'sanitizeIdentifier'], $order));
            } else {
                $order = $this->sanitizeIdentifier($order);
            }
            $this->cacheOrderBy = " ORDER BY " . $order;
            return $this;
        }

        /**
         * Sets the LIMIT part of the SQL query.
         *
         * @param  mixed $limit - Limit value.
         * @return $this
         */
        public function limit(mixed $limit): mixed {
            if (is_array($limit)) {
                $limit = implode(', ', array_map('intval', $limit));
            } else {
                $limit = intval($limit);
            }
            $this->cacheLimit = " LIMIT " . $limit;
            return $this;
        }

        /**
         * Sets the JOIN part of the SQL query.
         *
         * @param  string $table - Table name.
         * @param  string $on - Join condition.
         * @param  string $type - Type of join (default: "INNER").
         * @return $this
         */
        public function join(string $table, string $on, string $type = "INNER") {
            $this->cacheJoin .= " $type JOIN " . $this->sanitizeIdentifier($table) . " ON " . $this->sanitizeIdentifier($on);
            return $this;
        }

        /**
         * Executes a raw SQL query.
         *
         * @param  string $sql - SQL query.
         * @return $this
         * @throws \Exception
         */
        public function query($sql) {
            $query = $this->DBmysqli->query($sql);

            if (!$query) {
                throw new \Exception("Query failed: " . $this->DBmysqli->error);
            }

            $this->cacheQuery = $query;
            return $this;
        }

        /**
         * Executes the built SELECT query.
         *
         * @param  string|false $table - Optional table name.
         * @return $this
         */
        public function get($table = false) {
            $sql = $this->buildFinalQuery($table);
            $this->query($sql);
            return $this;
        }

        /**
         * Executes the built SELECT query with a WHERE condition.
         *
         * @param  string|false $table - Optional table name.
         * @param  mixed $where - WHERE condition.
         * @return $this
         * @throws \Exception
         */
        public function get_where($table = false, $where = false) {
            if (!$where) {
                throw new \Exception("There is no 'where' condition found in the default function.");
            }
            $this->where($where);
            $sql = $this->buildFinalQuery($table);
            $this->query($sql);
            return $this;
        }

        /**
         * Builds the final SQL query from cached parts.
         *
         * @param  string|false $table - Optional table name.
         * @return string
         * @throws \Exception
         */
        private function buildFinalQuery($table = false) {
            $sql = $this->cacheSelect;
            if ($table) {
                $sql .= " FROM " . $this->sanitizeIdentifier($table);
            } elseif ($this->cacheFrom) {
                $sql .= $this->cacheFrom;
            } else {
                throw new \Exception("Table name not provided.");
            }
            if ($this->cacheJoin) {
                $sql .= $this->cacheJoin;
            }
            if ($this->cacheWhere) {
                $sql .= $this->cacheWhere;
            }
            if ($this->cacheOrderBy) {
                $sql .= $this->cacheOrderBy;
            }
            if ($this->cacheLimit) {
                $sql .= $this->cacheLimit;
            }
            return $sql;
        }

        /**
         * Executes an INSERT query.
         *
         * @param  string $table - Table name.
         * @param  array $data - Data to insert.
         * @return $this
         */
        public function insert($table, $data) {
            $columns = implode(", ", array_map([$this, 'sanitizeIdentifier'], array_keys($data)));
            $values = implode("', '", array_map([$this->DBmysqli, 'real_escape_string'], array_values($data)));
            $sql = "INSERT INTO " . $this->sanitizeIdentifier($table) . " ($columns) VALUES ('$values')";
            $this->query($sql);
            return $this;
        }

        /**
         * Executes an INSERT query for multiple rows.
         *
         * @param  string $table - Table name.
         * @param  array $data - Data to insert (array of rows).
         * @return $this
         */
        public function insertMultiple($table, $data) {
            $columns = implode(", ", array_map([$this, 'sanitizeIdentifier'], array_keys($data[0])));
            $values = [];

            foreach ($data as $row) {
                $escapedValues = implode("', '", array_map([$this->DBmysqli, 'real_escape_string'], array_values($row)));
                $values[] = "('$escapedValues')";
            }

            $sql = "INSERT INTO " . $this->sanitizeIdentifier($table) . " ($columns) VALUES " . implode(", ", $values);
            $this->query($sql);
            return $this;
        }

        /**
         * Executes an UPDATE query.
         *
         * @param  string $table - Table name.
         * @param  array $data - Data to update.
         * @param  mixed $where - WHERE condition.
         * @return $this
         */
        public function update($table, $data, $where) {
            $set = [];
            foreach ($data as $column => $value) {
                $escapedValue = $this->DBmysqli->real_escape_string($value);
                $set[] = $this->sanitizeIdentifier($column) . " = '$escapedValue'";
            }

            $sql = "UPDATE " . $this->sanitizeIdentifier($table) . " SET " . implode(", ", $set) . $this->buildCondition($where, true);
            $this->query($sql);
            return $this;
        }

        /**
         * Executes a DELETE query.
         *
         * @param  string $table - Table name.
         * @param  mixed $where - WHERE condition.
         * @return $this
         */
        public function delete($table, $where) {
            $sql = "DELETE FROM " . $this->sanitizeIdentifier($table) . $this->buildCondition($where, true);
            $this->query($sql);
            return $this;
        }

        /**
         * Begins a transaction.
         *
         * @return void
         */
        public function begin() {
            $this->DBmysqli->begin_transaction();
        }

        /**
         * Commits the current transaction.
         *
         * @return void
         */
        public function commit() {
            $this->DBmysqli->commit();
        }

        /**
         * Rolls back the current transaction.
         *
         * @return void
         */
        public function rollback() {
            $this->DBmysqli->rollback();
        }

        /**
         * Returns all results from the last executed query.
         *
         * @return array|object - Array or object of results.
         * @throws \Exception
         */
        public function result() {
            return $this->fetchAll(true);
        }

        /**
         * Fetches all results as an associative array or object.
         *
         * @param  bool $toObject - Return as object if true.
         * @return array|object
         * @throws \Exception
         */
        public function fetchAll($toObject = false) {
            if (!$this->cacheQuery) {
                throw new \Exception("No cached query result found.");
            }

            $fetchAll = $this->cacheQuery->fetch_all(MYSQLI_ASSOC);

            if ($toObject) {
                $fetchAll = (object) $fetchAll;
            }

            $this->clearCache();

            return $fetchAll;
        }

        /**
         * Fetches a single row from the result set.
         *
         * @param  string $getFrom - Fetch "last" or "first" row (default: "last").
         * @return array|object
         * @throws \Exception
         */
        public function fetchRow($getFrom = "last") {
            if (!$this->cacheQuery) {
                throw new \Exception("No cached query result found.");
            }

            $fetchRow = $this->fetchAll(true);

            if ($getFrom === "last") {
                $fetchRow = end($fetchRow);
            } else {
                $fetchRow = reset($fetchRow);
            }

            return $fetchRow;
        }

        /**
         * Fetches a result row as an associative array.
         *
         * @return array
         */
        public function fetchAssoc() {
            return $this->cacheQuery->fetch_assoc();
        }

        /**
         * Fetches a result row as an enumerated array.
         *
         * @return array
         */
        public function fetchArray() {
            return $this->cacheQuery->fetch_array();
        }

        /**
         * Fetches a result row as an object.
         *
         * @return object
         */
        public function fetchObject() {
            return $this->cacheQuery->fetch_object();
        }

        /**
         * Clears all cached query parts.
         *
         * @return void
         */
        public function clearCache() {
            $this->cacheQuery = false;
            $this->cacheSelect = false;
            $this->cacheFrom = false;
            $this->cacheWhere = false;
            $this->cacheOrderBy = false;
            $this->cacheLimit = false;
            $this->cacheJoin = false;
        }

        /**
         * Builds the WHERE condition.
         *
         * @param  mixed $condition - Condition to build.
         * @param  bool $useWhere - Use WHERE keyword (default: false).
         * @return string
         */
        private function buildCondition($condition, $useWhere = false) {
            if (is_array($condition)) {
                $conditions = [];
                foreach ($condition as $key => $value) {
                    $escapedValue = $this->DBmysqli->real_escape_string($value);
                    $conditions[] = $this->sanitizeIdentifier($key) . " = '$escapedValue'";
                }
                return ($useWhere ? " WHERE " : "") . implode(" AND ", $conditions);
            }
            return $useWhere ? " WHERE " . $condition : $condition;
        }

        /**
         * Sanitizes SQL identifiers (e.g., column or table names).
         *
         * @param  string $identifier - Identifier to sanitize.
         * @return string
         */
        private function sanitizeIdentifier($identifier) {
            return preg_replace('/[^a-zA-Z0-9_]/', '', $identifier);
        }

        /**
         * Executes a raw SQL query and returns $this.
         *
         * @param  string $sql - SQL query.
         * @return $this
         */
        public function rawQuery($sql) {
            $this->query($sql);
            return $this;
        }

    }