
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
        $month = mysqli_real_escape_string($connection, trim($month ));


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