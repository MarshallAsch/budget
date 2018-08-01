
<?php

     /**
     * Function to initiate the connection to the SQL
     *
     */
    function initiateConnection()
    {
        $connection = mysqli_connect('127.0.0.1', 'budget_user', 'budget_pass', 'budget');

        //make sure connection was successful
        if (!$connection) {
                //echo "Failed to connect";
                return false;
        }


        //set the charset
        if (!mysqli_set_charset($connection, 'utf8')) {
                //echo "Failed to set the chatacter set";
                return false;
        }

        return $connection;
    }


    function getTransactionList()
    {
        $connection = initiateConnection();

        //conection failed to establish
        if (!$connection)
        {
            return false;
        }

        $instruct = 'SELECT id, date, amount, budget.name as description, tags.name as category FROM budget INNER JOIN tags ON budget.tag = tags.idtags';
        $result =  mysqli_query($connection, $instruct);

        if ($result->num_rows == 0)
        {
            return false;
        }
        $results = array();

        while($array = mysqli_fetch_assoc($result)) {
            array_push($results, $array);
        }

        // Free result set
        mysqli_free_result($result);

        //close connection
        mysqli_close($connection);

        return $results;
    }


	function getTotalsForMonth($year, $month)
    {
        $connection = initiateConnection();

        //conection failed to establish
        if (!$connection)
        {
            return false;
        }

        $year = mysqli_real_escape_string($connection, trim($year));
        $month = mysqli_real_escape_string($connection, trim($month));


        $instruct = 'SELECT COALESCE(total, 0) AS total, name  as name FROM (SELECT SUM(amount) AS total, tag FROM budget WHERE date > "'.$year.'-'.$month.'-01" AND date <= "'.$year.'-'.$month.'-31" AND tag != 7 group by tag) AS a  RIGHT JOIN (select * from tags where idtags != 7 AND idtags != 13 AND idtags != 10 AND idtags != 9) as b ON a.tag = b.idtags';
        $result =  mysqli_query($connection, $instruct);

        if ($result->num_rows == 0)
        {
            return false;
        }
        $results = array();

        while($array = mysqli_fetch_assoc($result)) {
            array_push($results, $array);
        }

        // Free result set
        mysqli_free_result($result);

        //close connection
        mysqli_close($connection);

        return $results;
    }


    function getTotoalTag($tag)
    {
        $connection = initiateConnection();

        //conection failed to establish
        if (!$connection)
        {
            return false;
        }

        $tag = mysqli_real_escape_string($connection, trim($tag));



        $instruct = 'select coalesce(spent, 0) as spent, b.date from (select CONCAT(CAST(YEAR(budget.date) AS CHAR(4)), \'-\', LPAD(CAST(MONTH(budget.date) AS CHAR(4)), 2, \'0\')) as date, sum(budget.amount) as spent from budget where tag = '.$tag.' group by CONCAT(CAST(YEAR(budget.date) AS CHAR(4)), \'-\', LPAD(CAST(MONTH(budget.date) AS CHAR(4)), 2, \'0\'))) as a right join (select CONCAT(CAST(YEAR(budget.date) AS CHAR(4)), \'-\', LPAD(CAST(MONTH(budget.date) AS CHAR(4)), 2, \'0\')) as date from budget group by CONCAT(CAST(YEAR(budget.date) AS CHAR(4)), \'-\', LPAD(CAST(MONTH(budget.date) AS CHAR(4)), 2, \'0\'))) as b on a.date = b.date order by b.date asc';
        $result =  mysqli_query($connection, $instruct);

        if ($result->num_rows == 0)
        {
            return false;
        }
        $results = array();

        while($array = mysqli_fetch_assoc($result)) {
            array_push($results, $array);
        }

        // Free result set
        mysqli_free_result($result);

        //close connection
        mysqli_close($connection);

        return $results;
    }


     function getAllDates()
    {
        $connection = initiateConnection();

        //conection failed to establish
        if (!$connection)
        {
            return false;
        }

        $tag = mysqli_real_escape_string($connection, trim($tag));


        $instruct = 'select CONCAT(CAST(YEAR(budget.date) AS CHAR(4)), \'-\', LPAD(CAST(MONTH(budget.date) AS CHAR(4)), 2, \'0\')) as date from budget group by CONCAT(CAST(YEAR(budget.date) AS CHAR(4)), \'-\', LPAD(CAST(MONTH(budget.date) AS CHAR(4)), 2, \'0\')) order by date asc';
        $result =  mysqli_query($connection, $instruct);

        if ($result->num_rows == 0)
        {
            return false;
        }
        $results = array();

        while($array = mysqli_fetch_assoc($result)) {
            array_push($results, $array);
        }

        // Free result set
        mysqli_free_result($result);

        //close connection
        mysqli_close($connection);

        return $results;
    }


    function getTagTitle($tag)
    {
        $connection = initiateConnection();

        //conection failed to establish
        if (!$connection)
        {
            return false;
        }

        $tag = mysqli_real_escape_string($connection, trim($tag));


        $instruct = 'SELECT name FROM tags WHERE idtags ='.$tag;
        $result =  mysqli_query($connection, $instruct);

        if ($result->num_rows == 0)
        {
            return false;
        }
        $results = array();

        while($array = mysqli_fetch_assoc($result)) {
            array_push($results, $array);
        }

        // Free result set
        mysqli_free_result($result);

        //close connection
        mysqli_close($connection);

        return $results[0]["name"];
    }

    function getTotalSpent()
    {
        $connection = initiateConnection();

        //conection failed to establish
        if (!$connection)
        {
            return false;
        }

        $tag = mysqli_real_escape_string($connection, trim($tag));


        $instruct = 'select CONCAT(CAST(YEAR(date) AS CHAR(4)), \'-\', LPAD(CAST(MONTH(budget.date) AS CHAR(4)), 2, \'0\')) as date, coalesce(sum(amount), 0) as spent from budget where tag != 7 AND tag != 13 group by CONCAT(CAST(YEAR(date) AS CHAR(4)), \'-\', LPAD(CAST(MONTH(budget.date) AS CHAR(4)), 2, \'0\')) order by date asc';
        $result =  mysqli_query($connection, $instruct);

        if ($result->num_rows == 0)
        {
            return false;
        }
        $results = array();

        while($array = mysqli_fetch_assoc($result)) {
            array_push($results, $array);
        }

        // Free result set
        mysqli_free_result($result);

        //close connection
        mysqli_close($connection);

        return $results;
    }