<?php


interface tblToRedis
{
    function setTtl($ttl);

    function setTable($table);

    function setColumns(array $columns);

    function persist(array $data);

    function persistPipe(array $data);
}