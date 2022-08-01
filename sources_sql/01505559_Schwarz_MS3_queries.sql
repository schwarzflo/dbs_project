--SOME QUERIES REQUESTED AS PART OF MS3

SELECT type,COUNT(type) AS amount FROM delivery group by type; --how many orders were of a specific type?

SELECT customerid, AVG(price) AS average_payment FROM orderr group by customerid order by average_payment DESC;
--how much money does a specific customer spend on an order on average?

SELECT orderid, COUNT(employeeid) AS AMOUNT_WORKING_ON FROM workson group by orderid order by amount_working_on DESC;
--how many employees were at some point associated with a specific order?

SELECT customerid, count(*) AS amount, SUM(price) AS customer_sales FROM orderr group by customerid HAVING sum(price) > 200 order by customer_sales DESC;
--how much money and how many orders are linked to a specific customer, IF THE CUSTOMER SPENT MORE THAN 200 EUR

SELECT customerid, employeeid, orderid FROM worksOn --link the customers directly to the employees in case of complaints
NATURAL JOIN orderr
NATURAL JOIN employee
ORDER BY orderid;
