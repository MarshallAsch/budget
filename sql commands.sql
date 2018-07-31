



-- sql commands for the program:


-- money spent each month
select CONCAT(CAST(YEAR(date) AS CHAR(4)), '-', CAST(MONTH(date) AS CHAR(4))) as date, sum(amount) as spent from budget where tag != 7 AND tag != 13 group by CONCAT(CAST(YEAR(date) AS CHAR(4)), '-', CAST(MONTH(date) AS CHAR(4)));



-- money made each month
select CONCAT(CAST(YEAR(date) AS CHAR(4)), '-', CAST(MONTH(date) AS CHAR(4))) as date, sum(amount) as spent from budget where tag = 7 group by CONCAT(CAST(YEAR(date) AS CHAR(4)), '-', CAST(MONTH(date) AS CHAR(4)));



-- monthly summery

select A.*, B.income, B.income - A.spent as net from (select CONCAT(CAST(YEAR(budget.date) AS CHAR(4)), '-', CAST(MONTH(budget.date) AS CHAR(4))) as date, sum(budget.amount) as spent from budget where tag != 7 AND TAG != 13 group by CONCAT(CAST(YEAR(budget.date) AS CHAR(4)), '-', CAST(MONTH(budget.date) AS CHAR(4)))) AS A inner join (select CONCAT(CAST(YEAR(budget.date) AS CHAR(4)), '-', CAST(MONTH(budget.date) AS CHAR(4))) as date, sum(budget.amount) as income from budget where tag = 7 group by CONCAT(CAST(YEAR(budget.date) AS CHAR(4)), '-', CAST(MONTH(budget.date) AS CHAR(4)))) AS B on A.date = B.date;






-- select average money made each month
select AVG(net) from (select A.*, B.income, B.income - A.spent as net from (select CONCAT(CAST(YEAR(budget.date) AS CHAR(4)), '-', CAST(MONTH(budget.date) AS CHAR(4))) as date, sum(budget.amount) as spent from budget where tag != 7 AND TAG != 13 group by CONCAT(CAST(YEAR(budget.date) AS CHAR(4)), '-', CAST(MONTH(budget.date) AS CHAR(4)))) AS A inner join (select CONCAT(CAST(YEAR(budget.date) AS CHAR(4)), '-', CAST(MONTH(budget.date) AS CHAR(4))) as date, sum(budget.amount) as income from budget where tag = 7 group by CONCAT(CAST(YEAR(budget.date) AS CHAR(4)), '-', CAST(MONTH(budget.date) AS CHAR(4)))) AS B on A.date = B.date) as C;




-- select average spent money each month
select AVG(spent) from (select CONCAT(CAST(YEAR(date) AS CHAR(4)), '-', CAST(MONTH(date) AS CHAR(4))) as date, sum(amount) as spent from budget where tag != 7 AND tag != 13 group by CONCAT(CAST(YEAR(date) AS CHAR(4)), '-', CAST(MONTH(date) AS CHAR(4)))) as B;


-- total by category
select coalesce(total, 0) as total, name  from (select sum(amount) as total, tag from budget where date > CONCAT(@YEAR, '-', @MONTH,'-01') AND date <= CONCAT(@YEAR, '-', @MONTH,'-31') group by tag) as a  right join tags on a.tag = tags.idtags;






select coalesce(total, 0) as total, name  from (select sum(amount) as total, tag from budget where date >= "2018-05-01" AND date <= "2018-05-31" AND tag != 7 group by tag) as a  right join (select * from tags where idtags != 7) as b ON a.tag = b.idtags;

