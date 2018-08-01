



-- sql commands for the program:


-- money spent each month
select CONCAT(CAST(YEAR(date) AS CHAR(4)), '-', LPAD(CAST(MONTH(budget.date) AS CHAR(4)), 2, '0')) as date, coalesce(sum(amount), 0) as spent from budget where tag != 7 AND tag != 13 group by CONCAT(CAST(YEAR(date) AS CHAR(4)), '-', LPAD(CAST(MONTH(budget.date) AS CHAR(4)), 2, '0'));



-- money made each month
select CONCAT(CAST(YEAR(date) AS CHAR(4)), '-', CAST(MONTH(date) AS CHAR(4))) as date, sum(amount) as spent from budget where tag = 7 group by CONCAT(CAST(YEAR(date) AS CHAR(4)), '-', CAST(MONTH(date) AS CHAR(4)));



-- monthly summery

select A.*, B.income, B.income - A.spent as net from (select CONCAT(CAST(YEAR(budget.date) AS CHAR(4)), '-', CAST(MONTH(budget.date) AS CHAR(4))) as date, sum(budget.amount) as spent from budget where tag != 7 AND TAG != 13 group by CONCAT(CAST(YEAR(budget.date) AS CHAR(4)), '-', CAST(MONTH(budget.date) AS CHAR(4)))) AS A inner join (select CONCAT(CAST(YEAR(budget.date) AS CHAR(4)), '-', CAST(MONTH(budget.date) AS CHAR(4))) as date, sum(budget.amount) as income from budget where tag = 7 group by CONCAT(CAST(YEAR(budget.date) AS CHAR(4)), '-', CAST(MONTH(budget.date) AS CHAR(4)))) AS B on A.date = B.date;






-- select average money made each month
select AVG(net) from (select A.*, B.income, B.income - A.spent as net from (select CONCAT(CAST(YEAR(budget.date) AS CHAR(4)), '-', CAST(MONTH(budget.date) AS CHAR(4))) as date, sum(budget.amount) as spent from budget where tag != 7 AND TAG != 13 group by CONCAT(CAST(YEAR(budget.date) AS CHAR(4)), '-', CAST(MONTH(budget.date) AS CHAR(4)))) AS A inner join (select CONCAT(CAST(YEAR(budget.date) AS CHAR(4)), '-', CAST(MONTH(budget.date) AS CHAR(4))) as date, sum(budget.amount) as income from budget where tag = 7 group by CONCAT(CAST(YEAR(budget.date) AS CHAR(4)), '-', CAST(MONTH(budget.date) AS CHAR(4)))) AS B on A.date = B.date) as C;




-- select average spent money each month
select AVG(spent) from (select CONCAT(CAST(YEAR(date) AS CHAR(4)), '-', CAST(MONTH(date) AS CHAR(4))) as date, sum(amount) as spent from budget where tag != 7 AND tag != 13 group by CONCAT(CAST(YEAR(date) AS CHAR(4)), '-', CAST(MONTH(date) AS CHAR(4)))) as B;


-- total by category
select b.date, coalesce(spent, 0) as spent  from (select CONCAT(CAST(YEAR(budget.date) AS CHAR(4)), '-', LPAD(CAST(MONTH(budget.date) AS CHAR(4)), 2, '0')) as date, sum(budget.amount) as spent from budget where tag = 8 group by CONCAT(CAST(YEAR(budget.date) AS CHAR(4)), '-', LPAD(CAST(MONTH(budget.date) AS CHAR(4)), 2, '0'))) as a right join (select CONCAT(CAST(YEAR(budget.date) AS CHAR(4)), '-', LPAD(CAST(MONTH(budget.date) AS CHAR(4)), 2, '0')) as date from budget group by CONCAT(CAST(YEAR(budget.date) AS CHAR(4)), '-', LPAD(CAST(MONTH(budget.date) AS CHAR(4)), 2, '0'))) as b on a.date = b.date order by b.date asc;


-- get all the months
select CONCAT(CAST(YEAR(budget.date) AS CHAR(4)), '-', LPAD(CAST(MONTH(budget.date) AS CHAR(4)), 2, '0')) as date from budget group by CONCAT(CAST(YEAR(budget.date) AS CHAR(4)), '-', LPAD(CAST(MONTH(budget.date) AS CHAR(4)), 2, '0'));





select CONCAT(CAST(YEAR(budget.date) AS CHAR(4)), '-', LPAD(CAST(MONTH(budget.date) AS CHAR(4)), 2, '0')) as date, sum(budget.amount) as spent from budget where tag = 3 group by CONCAT(CAST(YEAR(budget.date) AS CHAR(4)), '-', LPAD(CAST(MONTH(budget.date) AS CHAR(4)), 2, '0'));




-- get total spent for each month
select coalesce(spent, 0) as spent, b.date from (select CONCAT(CAST(YEAR(budget.date) AS CHAR(4)), '-', LPAD(CAST(MONTH(budget.date) AS CHAR(4)), 2, '0')) as date, sum(budget.amount) as spent from budget where tag = 3 group by CONCAT(CAST(YEAR(budget.date) AS CHAR(4)), '-', LPAD(CAST(MONTH(budget.date) AS CHAR(4)), 2, '0'))) as a right join (select CONCAT(CAST(YEAR(budget.date) AS CHAR(4)), '-', LPAD(CAST(MONTH(budget.date) AS CHAR(4)), 2, '0')) as date from budget group by CONCAT(CAST(YEAR(budget.date) AS CHAR(4)), '-', LPAD(CAST(MONTH(budget.date) AS CHAR(4)), 2, '0'))) as b on a.date = b.date;

