<?php

class DBUtils {
    public static function createSelectClause($columns) {
        if (empty($columns)) {
            return '*';
        }
        return implode(', ', $columns);
    }
}