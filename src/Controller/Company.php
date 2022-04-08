<?php

/*
 * Company
 * Data management class for company table.
 */


class Company
{
    private $connection;
    private $table = 'company';

    public $id;
    public $name;
    public $account_id;

    /**
     * Constructor
     * @param $db
     */
    public function __construct($db)
    {
        $this->connection = $db;
    }

    /**
     * Read all records.
     * @return mixed
     */
    public function read()
    {

        $query = "SELECT
            id,
            name,
            account_id
            FROM " . $this->table . " 
            ORDER BY name";

        $statement = $this->connection->prepare($query);

        $statement->execute();

        return $statement;
    }

    /**
     * Read a single, specified record.
     * @return int
     */
    public function read_single(): bool
    {

        $query = "SELECT
            id,
            name,
            account_id
            FROM " . $this->table . " 
            WHERE account_id = ?";

        $statement = $this->connection->prepare($query);

        $statement->bindParam(1, $this->account_id);

        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        // If matching company found, store data.
        if (! empty($row)) {

            $this->id = $row['id'];
            $this->name = $row['name'];
            $this->account_id = $row['account_id'];

            return true;
        }

        // Else, company not found.
        return false;
    }

    /**
     * Insert specified company into table.
     * @return bool
     */
    public function insert(): bool
    {

        $query = 'INSERT INTO ' . $this->table . '
            (name, account_id)
            VALUES (        
            :name,
            :account_id)';

        $statement = $this->connection->prepare($query);

        // Sanitize request data.
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->account_id = htmlspecialchars(strip_tags($this->account_id));

        // Insert request data into query.
        $statement->bindParam("name", $this->name, PDO::PARAM_STR);
        $statement->bindParam("account_id", $this->account_id, PDO::PARAM_STR);

        // Execute Insert request, and return if successful.
        if ($statement->execute()) {
            return true;
        };

        // If anything went wrong, pass error message along.
        printf('Error: %s \n', $statement->error);

        return false;
    }

}