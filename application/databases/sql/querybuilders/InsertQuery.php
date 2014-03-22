<?php
/**
 * Copyright (C) 2014 David Young
 *
 * Builds an insert query
 */
namespace RamODev\Application\Databases\SQL\QueryBuilders;

class InsertQuery extends Query
{
    /** @var AugmentingQueryBuilder Handles functionality common to augmenting queries */
    protected $augmentingQueryBuilder = null;

    /**
     * @param string $tableName The name of the table we're inserting into
     * @param array $columnNamesToValues The mapping of column names to their respective values
     */
    public function __construct($tableName, $columnNamesToValues)
    {
        $this->tableName = $tableName;
        $this->augmentingQueryBuilder = new AugmentingQueryBuilder();
        $this->addColumnValues($columnNamesToValues);
    }

    /**
     * Adds column values to the query
     *
     * @param array $columnNamesToValues The mapping of column names to their respective values
     * @return $this
     */
    public function addColumnValues($columnNamesToValues)
    {
        $this->addUnnamedPlaceholderValues(array_values($columnNamesToValues));
        $this->augmentingQueryBuilder->addColumnValues($columnNamesToValues);

        return $this;
    }

    /**
     * Gets the SQL statement as a string
     *
     * @return string The SQL statement
     */
    public function getSQL()
    {
        $sql = "INSERT INTO " . $this->tableName . " (" . implode(", ", array_keys($this->augmentingQueryBuilder->getColumnNamesToValues())) . ") VALUES (" . implode(", ", array_fill(0, count(array_values($this->augmentingQueryBuilder->getColumnNamesToValues())), "?")) . ")";

        return $sql;
    }

    /**
     * Sets the table we're querying
     *
     * @param string $tableName The name of the table we're querying
     */
    public function setTable($tableName)
    {
        parent::setTable($tableName);
    }
} 