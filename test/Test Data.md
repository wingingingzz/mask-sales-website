# Test Data

1. Please follow the guidance in "**README.md**" to open web pages and database.

2. Copy test data from "**Input for...**" row in sequence into corresponding text boxes and follow the instruction in "**Instruction**" column, the output should match the expected output. The **empty cells** in the tables mean entering nothing.

3. "**Execute SQL statements**" means copy and execute these statements in db "scyqw4".

<a name="contents"></a>

## Contents

* [Login](#login)
* [Register](#register)
* [Customer](#customer)
* [Salesrep](#salesrep)
* [Manager](#manager)



<a name="login"></a>

## Login

**src/login.html**

<h4>client-side validation of user inputs</h4>

| No.                               | 1                                                            | 2                                                            |
| --------------------------------- | ------------------------------------------------------------ | ------------------------------------------------------------ |
| **Description**                   | To test "**Username**" cannot be empty                       | To test "**Password**" cannot be empty                       |
| **Input for "Username" text box** |                                                              | manager                                                      |
| **Input for "Password" text box** |                                                              |                                                              |
| **Instruction**                   | click "**Login**" button                                     | click "**Login**" button                                     |
| **Expected output**               | Username cannot be empty.<br/>focus on "**Username**" text box | Password cannot be empty.<br/>focus on "**Password**" text box |

<h4>server-side validation of user inputs</h4>

| No.                               | 1                                                           | 2                                                            |
| --------------------------------- | ----------------------------------------------------------- | ------------------------------------------------------------ |
| **Description**                   | To test if password is incorrect                            | To test username does not exist                              |
| **Input for "Username" text box** | manager                                                     | Inexistentusername                                           |
| **Input for "Password" text box** | Incorrectpassword                                           | 123456                                                       |
| **Instruction**                   | click "**Login**" button                                    | click "**Login**" button                                     |
| **Expected output**               | Password is incorrect.<br/>focus on "**Password**" text box | Username does not exist.<br/>focus on "**Username**" text box |

<h4>login of 3 user types</h4>

Execute SQL statements

```mysql
-- to test salesrep login
INSERT INTO `account` (`username`, `password`, `user_type`) VALUES
('slogin', '123456', 'salesrep');

INSERT INTO `salesrep` (`employee_id`, `first_name`, `last_name`, `region`, `tel`, `email`, `quota`, `username`) VALUES
(1, 'Carl', 'Jones', 'UK', '38294065', 'CarlJones@gmail.com', 850, 'slogin');

-- to test customer login
INSERT INTO `account` (`username`, `password`, `user_type`) VALUES
('clogin', '123456', 'customer');

INSERT INTO `customer` (`username`, `first_name`, `last_name`, `passport_id`, `region`, `tel`, `email`) VALUES
('clogin', 'Cole', 'Smith', '384759384', 'UK', '39574859', 'ColeSmith@gmail.com');
```

| No.                               | 1                                      | 2                                       | 3                                       |
| --------------------------------- | -------------------------------------- | --------------------------------------- | --------------------------------------- |
| **Description**                   | To test if manager can login correctly | To test if salesrep can login correctly | To test if customer can login correctly |
| **Input for "Username" text box** | manager                                | slogin                                  | clogin                                  |
| **Input for "Password" text box** | 123456                                 | 123456                                  | 123456                                  |
| **Instruction**                   | click "**Login**" button               | click "**Login**" button                | click "**Login**" button                |
| **Expected output**               | jump to **src/manager/manager.php**    | jump to **src/salesrep/salesrep.php**   | jump to **src/customer/customer.php**   |

<h4>"Remember me" checkbox</h4>

| No.                               | 1                                                            | 2                                                            |
| --------------------------------- | ------------------------------------------------------------ | ------------------------------------------------------------ |
| **Description**                   | To test if username and password can be remembered correctly when "**Remember me**" check box is checked | To test if username and password will not be remembered when "**Remember me**" check box is unchecked |
| **Input for "Username" text box** | manager                                                      | manager                                                      |
| **Input for "Password" text box** | 123456                                                       | 123456                                                       |
| **"Remember me" chkbox**          | checked                                                      | unchecked                                                    |
| **Instruction**                   | click "**Login**" button<br/>back to login page              | click "**Login**" button<br/>back to login page              |
| **Expected output**               | "**manager**" in "**Username**" text box<br/>"123456" (**6 black dots**) in "**Password**" text box | nothing in "**Username**" text box<br/>nothing in "**Password**" text box<br/>**but it can be different because of cache of the browser!** |

<h4>Other designs for login</h4>

| No.                               | 1                                                            | 2                                                            |
| --------------------------------- | ------------------------------------------------------------ | ------------------------------------------------------------ |
| **Description**                   | To test if cursor focuses on "**Password**" text box when user press "**Enter**" on keyboard in "**Username**" text box | To test if login successfully when user press "**Enter**" on keyboard in "**Password**" text box |
| **Input for "Username" text box** | manager                                                      | manager                                                      |
| **Input for "Password" text box** |                                                              | 123456                                                       |
| **Instruction**                   | press "**Enter**" on keyboard when the cursor focuses on "**Username**" text box | press "**Enter**" on keyboard whenthe cursor focuses on "**Password**" text box |
| **Expected output**               | focus on "**Password**" text box                             | jump to **src/manager/manager.php**                          |

[return to contents](#contents)



<a name="register"></a>

## Register

**src/register.html**

<h4>client-side validation of user inputs</h4>

**Set Username**

| No.                                   | 1                                                            | 2                                             | 3                                         | 4                                                            | 5                                                            | 6                                         |
| ------------------------------------- | ------------------------------------------------------------ | --------------------------------------------- | ----------------------------------------- | ------------------------------------------------------------ | ------------------------------------------------------------ | ----------------------------------------- |
| **Description**                       | To test "**Set Username**" text box cannot be empty          | To test input should be no more than 25 chars | To test input  should be at least 2 chars | To  test  input should start with a letter and followed by only letters and digits | To test input with chars other than digits and letters       | To test valid input                       |
| **Input for "Set Username" text box** | cregister                                                    | Thisismorethan25characters                    | a                                         | 1startwithno                                                 | Usernamewith.                                                | cregister                                 |
| **Instruction**                       | lose focus on "**Set Username**" text box<br/>**delete input**<br/>lose focus on "**Set Username**" text box | lose focus on "**Set Username**" text box     | lose focus on "**Set Username**" text box | lose focus on "**Set Username**" text box                    | lose focus on "**Set Username**" text box                    | lose focus on "**Set Username**" text box |
| **Expected output**                   | Please enter your username.                                  | Please enter no more than 25 characters.      | Please enter at least 2 characters.       | Please start with a letter and enter only letters and digits. | Please start with a letter and enter only letters and digits. | Username is valid.                        |

**Set Password**

| No.                                   | 1                                                            | 2                                          | 3                                         | 4                                                            | 5                                                      | 6                                         |
| ------------------------------------- | ------------------------------------------------------------ | ------------------------------------------ | ----------------------------------------- | ------------------------------------------------------------ | ------------------------------------------------------ | ----------------------------------------- |
| **Description**                       | To test "**Set Password**" text box cannot be empty          | To test input can be no more than 25 chars | To test input  should be at least 6 chars | To  test  input should  be only letters and digits (no space is allowed) | To test input with chars other than digits and letters | To test valid input                       |
| **Input for "Set Password" text box** | 123456                                                       | Thisismorethan25characters                 | 12345                                     | With space                                                   | Passwordwith.                                          | 123456                                    |
| **Instruction**                       | lose focus on "**Set Password**" text box<br/>**delete input**<br/>lose focus on "**Set Password**" text box | lose focus on "**Set Password**" text box  | lose focus on "**Set Password**" text box | lose focus on "**Set Password**" text box                    | lose focus on "**Set Password**" text box              | lose focus on "**Set Password**" text box |
| **Expected output**                   | Please enter your password.                                  | Please enter no more than 25 characters.   | Please enter at least 6 characters.       | Please enter only letters and digits.                        | Please enter only letters and digits.                  | Password is valid.                        |

**Confirm Password**

| No.                                       | 1                                                            | 2                                                            | 3                                                        |
| ----------------------------------------- | ------------------------------------------------------------ | ------------------------------------------------------------ | -------------------------------------------------------- |
| **Description**                           | To test "**Confirm Password**" text box cannot be empty      | To test if **Confirm Password** does not match **Set Password** | To test if **Confirm Password** matches **Set Password** |
| **Input for "Set Password" text box**     | 123456                                                       | 123456                                                       | 123456                                                   |
| **Input for "Confirm Password" text box** | 123456                                                       | 12345678                                                     | 123456                                                   |
| **Instruction**                           | lose focus on "**Confirm Password**" text box<br/>**delete input for "Confirm Password" text box**<br/>lose focus on "**Confirm Password**" text box | lose focus on "**Confirm Password**" text box                | lose focus on "**Confirm Password**" text box            |
| **Expected output**                       | Please confirm your password.                                | Password does not match.                                     | Password is confirmed.                                   |

**First Name**

| No.                                 | 1                                                            | 2                                             | 3                                                            | 4                                       |
| ----------------------------------- | ------------------------------------------------------------ | --------------------------------------------- | ------------------------------------------------------------ | --------------------------------------- |
| **Description**                     | To test "**First Name**" text box cannot be empty            | To test input should be no more than 25 chars | To test input should start with a capital letter and followed by only lower case letters | To test valid input                     |
| **Input for "First Name" text box** | Wing                                                         | Morethantwentyfivecharacters                  | Wingwith.                                                    | Wing                                    |
| **Instruction**                     | lose focus on "**First Name**" text box<br/>**delete input**<br/>lose focus on "**First Name**" text box | lose focus on "**First Name**" text box       | lose focus on "**First Name**" text box                      | lose focus on "**First Name**" text box |
| **Expected output**                 | Please enter your first name.                                | Please enter no more than 25 characters.      | Please start with a capital letter and the following are only lower case letters. | First name is valid.                    |

**Last Name**

| No.                                | 1                                                            | 2                                             | 3                                                            | 4                                      |
| ---------------------------------- | ------------------------------------------------------------ | --------------------------------------------- | ------------------------------------------------------------ | -------------------------------------- |
| **Description**                    | To test "**Last Name**" text box cannot be empty             | To test input should be no more than 25 chars | To test input should start with a capital letter and followed by only lower case letters | To test valid input                    |
| **Input for "Last Name" text box** | Wang                                                         | Morethantwentyfivecharacters                  | Wangwith.                                                    | Wang                                   |
| **Instruction**                    | lose focus on "**Last Name**" text box<br/>**delete input**<br/>lose focus on "**Last Name**" text box | lose focus on "**Last Name**" text box        | lose focus on "**Last Name**" text box                       | lose focus on "**Last Name**" text box |
| **Expected output**                | Please enter your last name.                                 | Please enter no more than 25 characters.      | Please start with a capital letter and the following are only lower case letters. | Last name is valid.                    |

**Passport ID**

| No.                                  | 1                                                            | 2                                             | 3                                                       | 4                                        |
| ------------------------------------ | ------------------------------------------------------------ | --------------------------------------------- | ------------------------------------------------------- | ---------------------------------------- |
| **Description**                      | To test "**Passport ID**" text box cannot be empty           | To test input should be no more than 25 chars | To test input should only be capital letters and digits | To test valid input                      |
| **Input for "Passport ID" text box** | E48394050                                                    | 12345678901234567890123456                    | e48394050                                               | E48394050                                |
| **Instruction**                      | lose focus on "**Passport ID**" text box<br/>**delete input**<br/>lose focus on "**Passport ID**" text box | lose focus on "**Passport ID**" text box      | lose focus on "**Passport ID**" text box                | lose focus on "**Passport ID**" text box |
| **Expected output**                  | Please enter your passport ID.                               | Please enter no more than 25 characters.      | Please enter only capital letters and digits.           | Passport ID is valid.                    |

**Telephone No**

| No.                                   | 1                                                            | 2                                             | 3                                         | 4                                         |
| ------------------------------------- | ------------------------------------------------------------ | --------------------------------------------- | ----------------------------------------- | ----------------------------------------- |
| **Description**                       | To test "**Telephone No**" text box cannot be empty          | To test input should be no more than 25 chars | To test input should only be digits       | To test valid input                       |
| **Input for "Telephone No" text box** | 13500000000                                                  | 12345678901234567890123456                    | 135000a00000                              | 13500000000                               |
| **Instruction**                       | lose focus on "**Telephone No**" text box<br/>**delete input**<br/>lose focus on "**Telephone No**" text box | lose focus on "**Telephone No**" text box     | lose focus on "**Telephone No**" text box | lose focus on "**Telephone No**" text box |
| **Expected output**                   | Please enter your telephone number.                          | Please enter no more than 25 digits.          | Please enter only digits.                 | Telephone number is valid.                |

**Email**

| No.                            | 1                                                            | 2                                                            | 3                                  | 4                                      | 5                                  |
| ------------------------------ | ------------------------------------------------------------ | ------------------------------------------------------------ | ---------------------------------- | -------------------------------------- | ---------------------------------- |
| **Description**                | To test "**Email**" text box cannot be empty                 | To test input should be no more than 50 chars                | To test email in incorrect format  | To test valid format "XXX@XXX.XXX.XXX" | To test valid format "XXX@XXX.XXX" |
| **Input for "Email" text box** | wing-wang@gmail.com                                          | 12345678901234567890123456789012345678901234567890@gmail.com | wing-wang@gmail                    | wing.wang@nottingham.edu.cn            | wing-wang@gmail.com                |
| **Instruction**                | lose focus on "**Email**" text box<br/>**delete input**<br/>lose focus on "**Email**" text box | lose focus on "**Email**" text box                           | lose focus on "**Email**" text box | lose focus on "**Email**" text box     | lose focus on "**Email**" text box |
| **Expected output**            | Please enter your email.                                     | Please enter no more than 50 characters.                     | Please enter correct email.        | Email is valid.                        | Email is valid.                    |

<h4>server-side validation of user inputs</h4>

User with username "**clogin**" should have been added to table "account" and "customer" when testing login page.

| No.                                       | 1                                                            |
| ----------------------------------------- | ------------------------------------------------------------ |
| **Description**                           | To test if username has been registered                      |
| **Input for "Set Username" text box**     | clogin                                                       |
| **Input for "Set Password" text box**     | 123456                                                       |
| **Input for "Confirm Password" text box** | 123456                                                       |
| **Input for "First Name" text box**       | Wing                                                         |
| **Input for "Last Name" text box**        | Wang                                                         |
| **Input for "Passport ID" text box**      | E48394050                                                    |
| **Input for "Region"**                    | China                                                        |
| **Input for "Telephone No" text box**     | 13500000000                                                  |
| **Input for "Email" text box**            | wing-wang@gmail.com                                          |
| **Instruction**                           | click "**Register**" button                                  |
| **Expected output**                       | The username has been registered. Please change a username and try again.<br/>focus on "**Set Username**" text box |

<h4>successful registration</h4>

| No.                                       | 1                                                            |
| ----------------------------------------- | ------------------------------------------------------------ |
| **Description**                           | To test successful registration                              |
| **Input for "Set Username" text box**     | cregister                                                    |
| **Input for "Set Password" text box**     | 123456                                                       |
| **Input for "Confirm Password" text box** | 123456                                                       |
| **Input for "First Name" text box**       | Wing                                                         |
| **Input for "Last Name" text box**        | Wang                                                         |
| **Input for "Passport ID" text box**      | E48394050                                                    |
| **Input for "Region"**                    | China                                                        |
| **Input for "Telephone No" text box**     | 13500000000                                                  |
| **Input for "Email" text box**            | wing-wang@gmail.com                                          |
| **Instruction**                           | click "**Register**" button                                  |
| **Expected output**                       | alert "You have successfully registered."<br/>jump to login page |

[return to contents](#contents)



<a name="customer"></a>

## Customer

Execute SQL statements

```mysql
-- preset some salesreps
INSERT INTO `account` (`username`, `password`, `user_type`) VALUES
('schina1', '123456', 'salesrep'),
('schina2', '123456', 'salesrep'),
('schina3', '123456', 'salesrep'),
('skorea1', '123456', 'salesrep'),
('sthailand1', '123456', 'salesrep'),
('suk1', '123456', 'salesrep');

INSERT INTO `salesrep` (`employee_id`, `first_name`, `last_name`, `region`, `tel`, `email`, `quota`, `username`) VALUES
(2, 'Yang', 'Zhao', 'China', '13627488590', 'yang-zhao@qq.com', 1600, 'schina1'),
(3, 'Hua', 'Li', 'China', '18294890023', 'Hua-Li@qq.com', 1450, 'schina2'),
(4, 'Ming', 'Li', 'Thailand', '13928446578', 'ming.li@gmail.com', 3200, 'sthailand1'),
(5, 'Annie', 'Zhang', 'UK', '13728374993', 'A-Zhang@outlook.com', 2740, 'suk1'),
(6, 'Simon', 'Chen', 'Korea', '18047283946', 'Simon@outlook.com', 2490, 'skorea1'),
(7, 'Na', 'Liu', 'China', '12738223940', 'nana@163.com', 710, 'schina3');

-- preset some customers
INSERT INTO `account` (`username`, `password`, `user_type`) VALUES
('cchina1', '123456', 'customer');

INSERT INTO `customer` (`username`, `first_name`, `last_name`, `passport_id`, `region`, `tel`, `email`) VALUES
('cchina1', 'Cathy', 'Qian', 'E93840221', 'China', '12947382929', '325295783@qq.com');
```

<h3>login first</h3>

**src/login.html**

| **Description**                       | use a customer's username and password to login first |
| ------------------------------------- | ----------------------------------------------------- |
| **Input for "Set Username" text box** | cchina1                                               |
| **Input for "Set Password" text box** | 123456                                                |
| **Instruction**                       | click "**Login**" button                              |
| **Expected output**                   | jump to **src/customer/customer.php**                 |

<h3>Home Page</h3>

**src/customer/customer.php**

<h4>View salesreps who can be assigned</h4>

All salesreps that can be chosen by this customer are displayed (in the same region China):

| employee id | username | telephone   | email            | quota |
| ----------- | -------- | ----------- | ---------------- | ----- |
| 2           | schina1  | 13627488590 | yang-zhao@qq.com | 1600  |
| 3           | schina2  | 18294890023 | Hua-Li@qq.com    | 1450  |
| 7           | schina3  | 12738223940 | nana@163.com     | 710   |

<h4>check unit price of 3 types of mask</h4>

| mask type                | unit price |
| ------------------------ | ---------- |
| N95 respirators          | 10.00      |
| surgical masks           | 1.50       |
| surgical N95 respirators | 18.80      |

<h4>client-side validation of user inputs</h4>

**Quantity**

| No.                               | 1                                                            | 2                                     | 3                                           | 4                                              | 5                                     |
| --------------------------------- | ------------------------------------------------------------ | ------------------------------------- | ------------------------------------------- | ---------------------------------------------- | ------------------------------------- |
| **Description**                   | To test "**Quantity**" text box cannot be empty              | To test if negative number is invalid | To test if floating point number is invalid | To test if chars other than digits are invalid | To test valid input for quantity      |
| **Input for "Quantity" text box** | 10                                                           | -10                                   | 10.5                                        | str                                            | 10                                    |
| **Instruction**                   | lose focus on "**Quantity**" text box<br/>**delete input**<br/>lose focus on "**Quantity**" text box | lose focus on "**Quantity**" text box | lose focus on "**Quantity**" text box       | lose focus on "**Quantity**" text box          | lose focus on "**Quantity**" text box |
| **Expected output**               | Please enter quantity of masks you want to purchase.         | Please enter only positive integer.   | Please enter only positive integer.         | Please enter only positive integer.            | Quantity is valid.                    |

**Assign sales representative**

| No.                                                  | 1                                                            | 2                                                        | 3                                                        | 4                                                        | 5                                                        |
| ---------------------------------------------------- | ------------------------------------------------------------ | -------------------------------------------------------- | -------------------------------------------------------- | -------------------------------------------------------- | -------------------------------------------------------- |
| **Description**                                      | To test "**Assign sales representative**" text box cannot be empty | To test if negative number is invalid                    | To test if floating point number is invalid              | To test if chars other than digits are invalid           | To test valid input for employee ID                      |
| **Input for "Assign sales representative" text box** | 2                                                            | -2                                                       | 2.5                                                      | schina1                                                  | 2                                                        |
| **Instruction**                                      | lose focus on "**Assign sales representative**" text box<br/>**delete input**<br/>lose focus on "**Assign sales representative**" text box | lose focus on "**Assign sales representative**" text box | lose focus on "**Assign sales representative**" text box | lose focus on "**Assign sales representative**" text box | lose focus on "**Assign sales representative**" text box |
| **Expected output**                                  | Please enter an employee id of salesrep.                     | Please enter only valid employee id of salesrep.         | Please enter only valid employee id of salesrep.         | Please enter only valid employee id of salesrep.         | Employee id is valid.                                    |

<h4>server-side validation of user inputs</h4>

| No.                                                  | 1                                                            | 2                                                            |
| ---------------------------------------------------- | ------------------------------------------------------------ | ------------------------------------------------------------ |
| **Description**                                      | To test if the salesrep chosen by customer does not exist    | To test if the region of salesrep chosen by customer does not match |
| **Input for "Quantity" text box**                    | 10                                                           | 10                                                           |
| **Input for "Assign sales representative" text box** | 100                                                          | 4                                                            |
| **Instruction**                                      | click "**Order**" button                                     | click "**Order**" button                                     |
| **Expected output**                                  | You're unable to select this sales representative. Please select again.<br/>focus on "**Assign sales representative**" text box | You're unable to select this sales representative. Please select again.<br/>focus on "**Assign sales representative**" text box |

<h4>successful order</h4>

| No.                                                  | 1                                                            | 2                                                            |
| ---------------------------------------------------- | ------------------------------------------------------------ | ------------------------------------------------------------ |
| **Description**                                      | To test successful order (without anomaly, status is N)      | To test successful order (with anomaly status is A)          |
| **Input for "Mask Type"**                            | N95 respirators                                              | N95 respirators                                              |
| **Input for "Quantity" text box**                    | 10                                                           | 800                                                          |
| **Input for "Assign sales representative" text box** | 2                                                            | 7                                                            |
| **Instruction**                                      | click "**Order**" button                                     | click "**Order**" button                                     |
| **Expected output**                                  | alert "Ordered successfully. You've paid 100 RMB."<br/>Quota of salesrep "**schina1**" is 1590. | alert "Ordered successfully. You've paid 8000 RMB."<br/>Quota of salesrep "**schina3**" is -90. |



<h3>Orders</h3>

click "**Orders**" hyperlink in the header

**src/customer/customer_orders.php**

<h4>check orders table</h4>

All orders that are placed by this customer (these orders are placed when test "Home Page" as instructed):

| ordering id | mask type | quantity | sales amount | order time                              | status | salesrep  username | telephone   | email            |
| ----------- | --------- | -------- | ------------ | --------------------------------------- | ------ | ------------------ | ----------- | ---------------- |
| 1           | N95       | 10       | 100.00       | **actual time of testing "Home Page"!** | N      | schina1            | 13627488590 | yang-zhao@qq.com |
| 2           | N95       | 800      | 8000.00      | **actual time of testing "Home Page"!** | A      | schina3            | 12738223940 | nana@163.com     |

Execute SQL statements

**Important**: As the ordering id is automatically incremented, if ordering id has conflict with the orders in the database, please change it manually. Or ignore this if no conflict.

**Please change the creation time of the orders as instructed in the comments!**

```mysql
-- insert some orders of current customer which are over 24 hours
INSERT INTO `ordering` (`ordering_id`, `mask_type`, `quantity`, `sales_amount`, `creation_time`, `status`, `customer_username`, `salesrep_employee_id`) VALUES
(3, 'SN95', 50, '940.00', '2020-05-22 15:00:00', 'N', 'cchina1', 3),
(4, 'S', 170, '255.00', '2020-05-22 08:30:00', 'N', 'cchina1', 2),
(5, 'N95', 5000, '50000.00', '2020-05-17 23:00:00', 'A', 'cchina1', 2);

-- insert some orders of other customer which are within 24 hours
-- Important: Please change the creation time of orders to time within 24 hours when testing!
INSERT INTO `ordering` (`ordering_id`, `mask_type`, `quantity`, `sales_amount`, `creation_time`, `status`, `customer_username`, `salesrep_employee_id`) VALUES
(6, 'SN95', 45, '846.00', '2020-05-23 15:00:00', 'N', 'clogin', 1), 
(7, 'N95', 6000, '60000.00', '2020-05-23 15:00:00', 'A', 'clogin', 1);
```

Refresh "Orders" page, the orders table should display **5 orders** in total for current customer.

<h4>client-side validation of user inputs</h4>

| No.                                  | 1                                                            | 2                                        | 3                                           | 4                                              | 5                                        |
| ------------------------------------ | ------------------------------------------------------------ | ---------------------------------------- | ------------------------------------------- | ---------------------------------------------- | ---------------------------------------- |
| **Description**                      | To test "**Ordering ID**" text box cannot be empty           | To test if negative number is invalid    | To test if floating point number is invalid | To test if chars other than digits are invalid | To test valid input for ordering ID      |
| **Input for "Ordering ID" text box** | 1                                                            | -1                                       | 1.5                                         | str                                            | 1                                        |
| **Instruction**                      | lose focus on "**Ordering ID**" text box<br/>**delete input**<br/>lose focus on "**Ordering ID**" text box | lose focus on "**Ordering ID**" text box | lose focus on "**Ordering ID**" text box    | lose focus on "**Ordering ID**" text box       | lose focus on "**Ordering ID**" text box |
| **Expected output**                  | Please enter the ordering ID of order that you want to delete. | Please enter only valid ordering ID.     | Please enter only valid ordering ID.        | Please enter only valid ordering ID.           | Ordering ID is valid.                    |

<h4>server-side validation of user inputs</h4>

| No.                                  | 1                                                            | 2                                                            | 3                                                            | 4                                                            |
| ------------------------------------ | ------------------------------------------------------------ | ------------------------------------------------------------ | ------------------------------------------------------------ | ------------------------------------------------------------ |
| **Description**                      | To test if the ordering ID entered by customer does not exist | To test if the ordering ID entered by customer does not belong to this customer | To test if customer want to delete anomaly (A) order over 24 hours | To test if customer want to delete normal (N) order over 24 hours |
| **Input for "Ordering ID" text box** | 100                                                          | 6                                                            | 5                                                            | 4                                                            |
| **Instruction**                      | click "**Delete**" button                                    | click "**Delete**" button                                    | click "**Delete**" button                                    | click "**Delete**" button                                    |
| **Expected output**                  | No such record to be deleted.<br/>focus on "**Ordering ID**" text box | Please enter only valid ordering ID.<br/>focus on "**Ordering ID**" text box | Over 24 hours. The order cannot be deleted.<br/>focus on "**Ordering ID**" text box | Over 24 hours. The order cannot be deleted.<br/>focus on "**Ordering ID**" text box |

<h4>successful deletion</h4>

| No.                                  | 1                                                            | 2                                                            |
| ------------------------------------ | ------------------------------------------------------------ | ------------------------------------------------------------ |
| **Description**                      | To test successfully delete normal (N) order within 24 hours | To test successfully delete anomaly (A) order within 24 hours |
| **Input for "Ordering ID" text box** | 1                                                            | 2                                                            |
| **Instruction**                      | click "**Delete**" button                                    | click "**Delete**" button                                    |
| **Expected output**                  | alert "Delete order 1 successfully."<br/>order with **ordering ID 1** disappears from **"View all orders"** table | alert "Delete order 2 successfully."<br/>order with **ordering ID 2** disappears from **"View all orders"** table |

Now, only **order 3, 4, 5** remains in **"View all orders" table**.



<h3>User Center</h3>

click "**User Center**" hyperlink on the header

**src/customer/user_center.html**

<h4>Authentication</h4>

**client-side validation of user inputs**

| No.                                          | 1                                                            | 2                                                | 3                                                | 4                                                  | 5                                                      | 6                                                |
| -------------------------------------------- | ------------------------------------------------------------ | ------------------------------------------------ | ------------------------------------------------ | -------------------------------------------------- | ------------------------------------------------------ | ------------------------------------------------ |
| **Description**                              | To test "**Enter Your Password**" text box cannot be empty   | To test input can be no more than 25 chars       | To test input  should be at least 6 chars        | To  test  input should  be only letters and digits | To test input with chars other than digits and letters | To test valid input                              |
| **Input for "Enter Your Password" text box** | 123456                                                       | 12345678901234567890123456                       | 12345                                            | 123 456                                            | 123.456                                                | 123456                                           |
| **Instruction**                              | lose focus on "**Enter Your Password**" text box<br/>**delete input**<br/>lose focus on "**Enter Your Password**" text box | lose focus on "**Enter Your Password**" text box | lose focus on "**Enter Your Password**" text box | lose focus on "**Enter Your Password**" text box   | lose focus on "**Enter Your Password**" text box       | lose focus on "**Enter Your Password**" text box |
| **Expected output**                          | Please enter your password.                                  | Please enter no more than 25 characters.         | Please enter at least 6 characters.              | Please enter only letters and digits.              | Please enter only letters and digits.                  | Password is valid.                               |

**server-side validation of user inputs**

| No.                                          | 1                                                   | 2                              |
| -------------------------------------------- | --------------------------------------------------- | ------------------------------ |
| **Description**                              | To test if password is incorrect                    | To test if password is correct |
| **Input for "Enter Your Password" text box** | 12345678                                            | 123456                         |
| **Instruction**                              | click "**Athenticate**" button                      | click "**Athenticate**" button |
| **Expected output**                          | Authentication failure. Your password is incorrect. | jump to "**modify_info.html**" |

<h4>Modify info</h4>

**src/customer/modify_info.html**

**check info before modification**

| Name                | Value                 |
| ------------------- | --------------------- |
| Username (disabled) | None                  |
| Password            | 123456 (6 black dots) |
| Confirm Password    | 123456 (6 black dots) |
| Modify First Name   | Cathy                 |
| Modify Last Name    | Qian                  |
| Modify Passport ID  | E93840221             |
| Modify Region       | China                 |
| Modify Telephone No | 12947382929           |
| Modify Email        | 325295783@qq.com      |

**client-side validation of user inputs**

Replace existing/current input by contents in row named "**Input for...**". If the cell is empty, then remain current input without deleting them.

**Password**

| No.                               | 1                                                            | 2                                          | 3                                         | 4                                                  | 5                                                      | 6                                     |
| --------------------------------- | ------------------------------------------------------------ | ------------------------------------------ | ----------------------------------------- | -------------------------------------------------- | ------------------------------------------------------ | ------------------------------------- |
| **Description**                   | To test "**Enter Your Password**" text box cannot be empty   | To test input can be no more than 25 chars | To test input  should be at least 6 chars | To  test  input should  be only letters and digits | To test input with chars other than digits and letters | To test valid input                   |
| **Input for "Password" text box** | 12345678                                                     | 12345678901234567890123456                 | 12345                                     | 123 456                                            | 123.456                                                | 12345678                              |
| **Instruction**                   | lose focus on "**Password**" text box<br/>**delete input**<br/>lose focus on "**Password**" text box | lose focus on "**Password**" text box      | lose focus on "**Password**" text box     | lose focus on "**Password**" text box              | lose focus on "**Password**" text box                  | lose focus on "**Password**" text box |
| **Expected output**               | Please enter your password.                                  | Please enter no more than 25 characters.   | Please enter at least 6 characters.       | Please enter only letters and digits.              | Please enter only letters and digits.                  | Password is valid.                    |

**Confirm Password**

| No.                                       | 1                                                            | 2                                                           | 3                                                    |
| ----------------------------------------- | ------------------------------------------------------------ | ----------------------------------------------------------- | ---------------------------------------------------- |
| **Description**                           | To test "**Confirm Password**" text box cannot be empty      | To test if **Confirm Password** does not match **Password** | To test if **Confirm Password** matches **Password** |
| **Input for "Password" text box**         | 12345678                                                     | 12345678                                                    | 12345678                                             |
| **Input for "Confirm Password" text box** | 12345678                                                     | 123456                                                      | 12345678                                             |
| **Instruction**                           | lose focus on "**Confirm Password**" text box<br/>**delete input for "Confirm Password" text box**<br/>lose focus on "**Confirm Password**" text box | lose focus on "**Confirm Password**" text box               | lose focus on "**Confirm Password**" text box        |
| **Expected output**                       | Please confirm your password.                                | Password does not match.                                    | Password is confirmed.                               |

**First Name**

| No.                                        | 1                                                            | 2                                              | 3                                                            | 4                                              |
| ------------------------------------------ | ------------------------------------------------------------ | ---------------------------------------------- | ------------------------------------------------------------ | ---------------------------------------------- |
| **Description**                            | To test "**Modify First Name**" text box cannot be empty     | To test input should be no more than 25 chars  | To test input should start with a capital letter and followed by only lower case letters | To test valid input                            |
| **Input for "Modify First Name" text box** | Cassie                                                       | Morethantwentyfivecharacters                   | Ca ssie                                                      | Cassie                                         |
| **Instruction**                            | lose focus on "**Modify First Name**" text box<br/>**delete input**<br/>lose focus on "**Modify First Name**" text box | lose focus on "**Modify First Name**" text box | lose focus on "**Modify First Name**" text box               | lose focus on "**Modify First Name**" text box |
| **Expected output**                        | Please enter your first name.                                | Please enter no more than 25 characters.       | Please start with a capital letter and the following are only lower case letters. | First name is valid.                           |

**Modify Last Name**

| No.                                       | 1                                                            | 2                                             | 3                                                            | 4                                             |
| ----------------------------------------- | ------------------------------------------------------------ | --------------------------------------------- | ------------------------------------------------------------ | --------------------------------------------- |
| **Description**                           | To test "**Modify Last Name**" text box cannot be empty      | To test input should be no more than 25 chars | To test input should start with a capital letter and followed by only lower case letters | To test valid input                           |
| **Input for "Modify Last Name" text box** | Qiang                                                        | Morethantwentyfivecharacters                  | qiang                                                        | Qiang                                         |
| **Instruction**                           | lose focus on "**Modify Last Name**" text box<br/>**delete input**<br/>lose focus on "**Last Name**" text box | lose focus on "**Modify Last Name**" text box | lose focus on "**Modify Last Name**" text box                | lose focus on "**Modify Last Name**" text box |
| **Expected output**                       | Please enter your last name.                                 | Please enter no more than 25 characters.      | Please start with a capital letter and the following are only lower case letters. | Last name is valid.                           |

**Modify Passport ID**

| No.                                         | 1                                                            | 2                                               | 3                                                       | 4                                               |
| ------------------------------------------- | ------------------------------------------------------------ | ----------------------------------------------- | ------------------------------------------------------- | ----------------------------------------------- |
| **Description**                             | To test "**Modify Passport ID**" text box cannot be empty    | To test input should be no more than 25 chars   | To test input should only be capital letters and digits | To test valid input                             |
| **Input for "Modify Passport ID" text box** | E382950394                                                   | 12345678901234567890123456                      | 4839 4050                                               | E382950394                                      |
| **Instruction**                             | lose focus on "**Modify Passport ID**" text box<br/>**delete input**<br/>lose focus on "**Modify Passport ID**" text box | lose focus on "**Modify Passport ID**" text box | lose focus on "**Modify Passport ID**" text box         | lose focus on "**Modify Passport ID**" text box |
| **Expected output**                         | Please enter your passport ID.                               | Please enter no more than 25 characters.        | Please enter only capital letters and digits.           | Passport ID is valid.                           |

**Modify Telephone No**

| No.                                          | 1                                                            | 2                                                | 3                                                | 4                                                |
| -------------------------------------------- | ------------------------------------------------------------ | ------------------------------------------------ | ------------------------------------------------ | ------------------------------------------------ |
| **Description**                              | To test "**Modify Telephone No**" text box cannot be empty   | To test input should be no more than 25 chars    | To test input should only be digits              | To test valid input                              |
| **Input for "Modify Telephone No" text box** | 13538493049                                                  | 12345678901234567890123456                       | 135384.93049                                     | 13538493049                                      |
| **Instruction**                              | lose focus on "**Modify Telephone No**" text box<br/>**delete input**<br/>lose focus on "**Telephone No**" text box | lose focus on "**Modify Telephone No**" text box | lose focus on "**Modify Telephone No**" text box | lose focus on "**Modify Telephone No**" text box |
| **Expected output**                          | Please enter your telephone number.                          | Please enter no more than 25 digits.             | Please enter only digits.                        | Telephone number is valid.                       |

**Modify Email**

| No.                                   | 1                                                            | 2                                                            | 3                                         | 4                                         | 5                                         |
| ------------------------------------- | ------------------------------------------------------------ | ------------------------------------------------------------ | ----------------------------------------- | ----------------------------------------- | ----------------------------------------- |
| **Description**                       | To test "**Modify Email**" text box cannot be empty          | To test input should be no more than 50 chars                | To test email in incorrect format         | To test valid format "XXX@XXX.XXX.XXX"    | To test valid format "XXX@XXX.XXX"        |
| **Input for "Modify Email" text box** | cassie.q@gmail.com                                           | 12345678901234567890123456789012345678901234567890@gmail.com | cassie.q@gmail                            | cassie.q@nottingham.edu.cn                | cassie.q@gmail.com                        |
| **Instruction**                       | lose focus on "**Modify Email**" text box<br/>**delete input**<br/>lose focus on "**Modify Email**" text box | lose focus on "**Modify Email**" text box                    | lose focus on "**Modify Email**" text box | lose focus on "**Modify Email**" text box | lose focus on "**Modify Email**" text box |
| **Expected output**                   | Please enter your email.                                     | Please enter no more than 50 characters.                     | Please enter correct email.               | Email is valid.                           | Email is valid.                           |

<h4>successful modification</h4>

| No.                                          | 1                                                            |
| -------------------------------------------- | ------------------------------------------------------------ |
| **Description**                              | To modify all information                                    |
| **Input for "Password" text box**            | 12345678                                                     |
| **Input for "Confirm Password" text box**    | 12345678                                                     |
| **Input for "Modify First Name" text box**   | Cassie                                                       |
| **Input for "Modify Last Name" text box**    | Qiang                                                        |
| **Input for "Modify Passport ID" text box**  | E382950394                                                   |
| **Input for "Modify Region" text box**       | the United Kingdom                                           |
| **Input for "Modify Telephone No" text box** | 13538493049                                                  |
| **Input for "Modify Email" text box**        | cassie.q@gmail.com                                           |
| **Instruction**                              | click "**Save changes**" button                              |
| **Expected output**                          | alert "You've successfully saved changes."<br/>jump to "**customer.php**" |

click "**User Center**" hyperlink on the header

| **Input for "Enter Your Password" text box** | 12345678                        |
| -------------------------------------------- | ------------------------------- |
| **Instruction**                              | click "**Authenticate**" button |
| **Expected output**                          | jump to "**modify_info.html**"  |

**check info after modification**

| Name                | Value                   |
| ------------------- | ----------------------- |
| Username (disabled) | None                    |
| Password            | 12345678 (8 black dots) |
| Confirm Password    | 12345678 (8 black dots) |
| Modify First Name   | Cassie                  |
| Modify Last Name    | Qiang                   |
| Modify Passport ID  | E382950394              |
| Modify Region       | the United Kingdom      |
| Modify Telephone No | 13538493049             |
| Modify Email        | cassie.q@gmail.com      |

All the information matches the information modified during testing.

[return to contents](#contents)



<a name="salesrep"></a>

## Salesrep

Execute SQL statements

**Important: Please change the creation time of the orders as instructed in the comments!**

```mysql
-- insert some customers
INSERT INTO `account` (`username`, `password`, `user_type`) VALUES
('cchina2', '123456', 'customer');
INSERT INTO `customer` (`username`, `first_name`, `last_name`, `passport_id`, `region`, `tel`, `email`) VALUES
('cchina2', 'Ellie', 'Ma', 'E402800391', 'China', '19383749923', '3914872985@qq.com');

-- insert some orders which are over 24 hours
INSERT INTO `ordering` (`ordering_id`, `mask_type`, `quantity`, `sales_amount`, `creation_time`, `status`, `customer_username`, `salesrep_employee_id`) VALUES
(8, 'SN95', 3000, '56400.00', '2020-05-22 20:00:00', 'A', 'cchina2', 7);

-- insert some orders which are within 24 hours
-- Important: Please change the creation time of the orders below to time within 24 hours when testing!
INSERT INTO `ordering` (`ordering_id`, `mask_type`, `quantity`, `sales_amount`, `creation_time`, `status`, `customer_username`, `salesrep_employee_id`) VALUES
(9, 'S', 2000, '3000.00', '2020-05-23 20:00:00', 'A', 'cchina2', 7),
(10, 'N95', 2000, '20000.00', '2020-05-23 15:00:00', 'A', 'cchina2', 7);
-- test date: 2020-05-23 21:15:40
```

<h3>login first</h3>

**src/login.html**

| **Description**                       | use a salesrep's username and password to login first |
| ------------------------------------- | ----------------------------------------------------- |
| **Input for "Set Username" text box** | schina3                                               |
| **Input for "Set Password" text box** | 123456                                                |
| **Instruction**                       | click "**Login**" button                              |
| **Expected output**                   | jump to **src/salesrep/salesrep.php**                 |

<h3>Orders</h3>

**src/salesrep/salesrep.php**

<h4>View all orders</h4>

All orders of this salesrep are displayed.

| id   | mask type | quantity | sales amount | order time                                                   | status | customer username | telephone   | email             |
| ---- | --------- | -------- | ------------ | ------------------------------------------------------------ | ------ | ----------------- | ----------- | ----------------- |
| 8    | SN95      | 3000     | 56400.00     | 2020-05-22 20:00:00                                          | A      | cchina2           | 19383749923 | 3914872985@qq.com |
| 9    | S         | 2000     | 3000.00      | 2020-05-23 20:00:00 (**The time should be modified to within 24 hours when execute SQL statements**) | A      | cchina2           | 19383749923 | 3914872985@qq.com |
| 10   | N95       | 2000     | 20000.00     | 2020-05-23 15:00:00 (**The time should be modified to within 24 hours when execute SQL statements**) | A      | cchina2           | 19383749923 | 3914872985@qq.com |

<h4>View anomaly orders</h4>

All anomaly orders within 24 hours that can be deleted are displayed.

| id   | mask type | quantity | sales amount | order time                                                   | status | customer username | telephone   | email             |
| ---- | --------- | -------- | ------------ | ------------------------------------------------------------ | ------ | ----------------- | ----------- | ----------------- |
| 9    | S         | 2000     | 3000.00      | 2020-05-23 20:00:00 (**The time should be modified to within 24 hours when execute SQL statements**) | A      | cchina2           | 19383749923 | 3914872985@qq.com |
| 10   | N95       | 2000     | 20000.00     | 2020-05-23 15:00:00 (**The time should be modified to within 24 hours when execute SQL statements**) | A      | cchina2           | 19383749923 | 3914872985@qq.com |

<h4>Delete anomaly orders</h4>

| No.                 | 1                                                            |
| ------------------- | ------------------------------------------------------------ |
| **Description**     | To test salesrep to delete anomaly orders within 24 hours    |
| **Instruction**     | click "**Delete anomaly orders**" button                     |
| **Expected output** | alert "Delete 2 records successfully."<br/>**order 9 and 10** are disappeared in both tables |

<h3>Info</h3>

click "**Info**" hyperlink on the header

**src/salesrep/view_quota.php**

| employee id | username | first name | last name | region | telephone   | email        | quota |
| ----------- | -------- | ---------- | --------- | ------ | ----------- | ------------ | ----- |
| 7           | schina3  | Na         | Liu       | China  | 12738223940 | nana@163.com | 4710  |

The salesrep's quota is changed from **710** to **4710** because he/she has **deleted anomaly order 9 and 10** in previous part of testing, where **quantity of order 9 is 2000 and order 10 is 2000**. After these two orders are deleted, salesrep's quota is incremented correspondingly.

[return to contents](#contents)



<a name="manager"></a>

## Manager

<h3>login first</h3>

**src/login.html**

| **Description**                       | use manager's username and password to login first |
| ------------------------------------- | -------------------------------------------------- |
| **Input for "Set Username" text box** | manager                                            |
| **Input for "Set Password" text box** | 123456                                             |
| **Instruction**                       | click "**Login**" button                           |
| **Expected output**                   | jump to **src/manager/manager.php**                |

<h3>Anomaly</h3>

**src/manager/manager.php**

<h4>View anomaly orders over 24 hours</h4>

test date: 2020-05-23 21:27:00

It can be different because of the creation time of orders, but all orders over 24 hours will be displayed.

| ordering id | mask type | quantity | sales amount | creation time       | status | customer username | salesrep employee id |
| ----------- | --------- | -------- | ------------ | ------------------- | ------ | ----------------- | -------------------- |
| 5           | N95       | 5000     | 50000.00     | 2020-05-17 23:00:00 | A      | cchina1           | 2                    |
| 8           | SN95      | 3000     | 56400.00     | 2020-05-22 20:00:00 | A      | cchina2           | 7                    |

<h3>Order</h3>

click "**Order**" hyperlink on the header

**src/manager/order.php**

<h4>View all orders</h4>

| ordering id | mask type | quantity | sales amount | creation time       | status | customer username | salesrep employee id |
| ----------- | --------- | -------- | ------------ | ------------------- | ------ | ----------------- | -------------------- |
| 3           | SN95      | 50       | 940.00       | 2020-05-22 15:00:00 | N      | cchina1           | 3                    |
| 4           | S         | 170      | 255.00       | 2020-05-22 08:30:00 | N      | cchina1           | 2                    |
| 5           | N95       | 5000     | 50000.00     | 2020-05-17 23:00:00 | A      | cchina1           | 2                    |
| 6           | SN95      | 45       | 846.00       | 2020-05-23 15:00:00 | N      | clogin            | 1                    |
| 7           | N95       | 6000     | 60000.00     | 2020-05-23 15:00:00 | A      | clogin            | 1                    |
| 8           | SN95      | 3000     | 56400.00     | 2020-05-22 20:00:00 | A      | cchina2           | 7                    |

<h3>Salesrep</h3>

click "**Salesrep**" hyperlink on the header

**src/manager/salesrep.html**

<h4>Assign salesrep</h4>

click "**Assign salesrep**" button

**src/manager/assign_salesrep.html**

**client-side validation of user inputs**

**Set Username**

| No.                                   | 1                                                            | 2                                             | 3                                         | 4                                                            | 5                                                            | 6                                         |
| ------------------------------------- | ------------------------------------------------------------ | --------------------------------------------- | ----------------------------------------- | ------------------------------------------------------------ | ------------------------------------------------------------ | ----------------------------------------- |
| **Description**                       | To test "**Set Username**" text box cannot be empty          | To test input should be no more than 25 chars | To test input  should be at least 2 chars | To  test  input should start with a letter and followed by only letters and digits | To test input with chars other than digits and letters       | To test valid input                       |
| **Input for "Set Username" text box** | sthailand2                                                   | Thisismorethan25characters                    | a                                         | 1startwithno                                                 | s thailand2                                                  | sthailand2                                |
| **Instruction**                       | lose focus on "**Set Username**" text box<br/>**delete input**<br/>lose focus on "**Set Username**" text box | lose focus on "**Set Username**" text box     | lose focus on "**Set Username**" text box | lose focus on "**Set Username**" text box                    | lose focus on "**Set Username**" text box                    | lose focus on "**Set Username**" text box |
| **Expected output**                   | Please enter your username.                                  | Please enter no more than 25 characters.      | Please enter at least 2 characters.       | Please start with a letter and enter only letters and digits. | Please start with a letter and enter only letters and digits. | Username is valid.                        |

**Set Password**

| No.                                   | 1                                                            | 2                                          | 3                                         | 4                                                  | 5                                                      | 6                                         |
| ------------------------------------- | ------------------------------------------------------------ | ------------------------------------------ | ----------------------------------------- | -------------------------------------------------- | ------------------------------------------------------ | ----------------------------------------- |
| **Description**                       | To test "**Set Password**" text box cannot be empty          | To test input can be no more than 25 chars | To test input  should be at least 6 chars | To  test  input should  be only letters and digits | To test input with chars other than digits and letters | To test valid input                       |
| **Input for "Set Password" text box** | 123456                                                       | Thisismorethan25characters                 | 12345                                     | With space                                         | Passwordwith.                                          | 123456                                    |
| **Instruction**                       | lose focus on "**Set Password**" text box<br/>**delete input**<br/>lose focus on "**Set Password**" text box | lose focus on "**Set Password**" text box  | lose focus on "**Set Password**" text box | lose focus on "**Set Password**" text box          | lose focus on "**Set Password**" text box              | lose focus on "**Set Password**" text box |
| **Expected output**                   | Please enter your password.                                  | Please enter no more than 25 characters.   | Please enter at least 6 characters.       | Please enter only letters and digits.              | Please enter only letters and digits.                  | Password is valid.                        |

**First Name**

| No.                                 | 1                                                            | 2                                             | 3                                                            | 4                                       |
| ----------------------------------- | ------------------------------------------------------------ | --------------------------------------------- | ------------------------------------------------------------ | --------------------------------------- |
| **Description**                     | To test "**First Name**" text box cannot be empty            | To test input should be no more than 25 chars | To test input should start with a capital letter and followed by only lower case letters | To test valid input                     |
| **Input for "First Name" text box** | Hebe                                                         | Morethantwentyfivecharacters                  | hebe                                                         | Hebe                                    |
| **Instruction**                     | lose focus on "**First Name**" text box<br/>**delete input**<br/>lose focus on "**First Name**" text box | lose focus on "**First Name**" text box       | lose focus on "**First Name**" text box                      | lose focus on "**First Name**" text box |
| **Expected output**                 | Please enter your first name.                                | Please enter no more than 25 characters.      | Please start with a capital letter and the following are only lower case letters. | First name is valid.                    |

**Last Name**

| No.                                | 1                                                            | 2                                             | 3                                                            | 4                                      |
| ---------------------------------- | ------------------------------------------------------------ | --------------------------------------------- | ------------------------------------------------------------ | -------------------------------------- |
| **Description**                    | To test "**Last Name**" text box cannot be empty             | To test input should be no more than 25 chars | To test input should start with a capital letter and followed by only lower case letters | To test valid input                    |
| **Input for "Last Name" text box** | Poy                                                          | Morethantwentyfivecharacters                  | P.oy                                                         | Poy                                    |
| **Instruction**                    | lose focus on "**Last Name**" text box<br/>**delete input**<br/>lose focus on "**Last Name**" text box | lose focus on "**Last Name**" text box        | lose focus on "**Last Name**" text box                       | lose focus on "**Last Name**" text box |
| **Expected output**                | Please enter your last name.                                 | Please enter no more than 25 characters.      | Please start with a capital letter and the following are only lower case letters. | Last name is valid.                    |

**Telephone No**

| No.                                   | 1                                                            | 2                                             | 3                                         | 4                                         |
| ------------------------------------- | ------------------------------------------------------------ | --------------------------------------------- | ----------------------------------------- | ----------------------------------------- |
| **Description**                       | To test "**Telephone No**" text box cannot be empty          | To test input should be no more than 25 chars | To test input should only be digits       | To test valid input                       |
| **Input for "Telephone No" text box** | 38594830                                                     | 12345678901234567890123456                    | 3859-4830                                 | 38594830                                  |
| **Instruction**                       | lose focus on "**Telephone No**" text box<br/>**delete input**<br/>lose focus on "**Telephone No**" text box | lose focus on "**Telephone No**" text box     | lose focus on "**Telephone No**" text box | lose focus on "**Telephone No**" text box |
| **Expected output**                   | Please enter your telephone number.                          | Please enter no more than 25 digits.          | Please enter only digits.                 | Telephone number is valid.                |

**Email**

| No.                            | 1                                                            | 2                                                            | 3                                  | 4                                      | 5                                  |
| ------------------------------ | ------------------------------------------------------------ | ------------------------------------------------------------ | ---------------------------------- | -------------------------------------- | ---------------------------------- |
| **Description**                | To test "**Email**" text box cannot be empty                 | To test input should be no more than 50 chars                | To test email in incorrect format  | To test valid format "XXX@XXX.XXX.XXX" | To test valid format "XXX@XXX.XXX" |
| **Input for "Email" text box** | poy666@gmail.com                                             | 12345678901234567890123456789012345678901234567890@gmail.com | poy666@gmail.                      | poy666@nottingham.edu.cn               | poy666@gmail.com                   |
| **Instruction**                | lose focus on "**Email**" text box<br/>**delete input**<br/>lose focus on "**Email**" text box | lose focus on "**Email**" text box                           | lose focus on "**Email**" text box | lose focus on "**Email**" text box     | lose focus on "**Email**" text box |
| **Expected output**            | Please enter your email.                                     | Please enter no more than 50 characters.                     | Please enter correct email.        | Email is valid.                        | Email is valid.                    |

**Set Quota**

| No.                                | 1                                                            | 2                                      | 3                                          | 4                                              | 5                                      |
| ---------------------------------- | ------------------------------------------------------------ | -------------------------------------- | ------------------------------------------ | ---------------------------------------------- | -------------------------------------- |
| **Description**                    | To test "**Set Quota**" text box cannot be empty             | To test if negative input is invalid   | To test if floating point input is invalid | To test if chars other than digits are invalid | To test valid input for quota          |
| **Input for "Set Quota" text box** | 666                                                          | -666                                   | 66.6                                       | 1a                                             | 666                                    |
| **Instruction**                    | lose focus on "**Set Quota**" text box<br/>**delete input**<br/>lose focus on "**Set Quota**" text box | lose focus on "**Set Quota**" text box | lose focus on "**Set Quota**" text box     | lose focus on "**Set Quota**" text box         | lose focus on "**Set Quota**" text box |
| **Expected output**                | Please enter quota for salesrep.                             | Please enter only positive integer.    | Please enter only positive integer.        | Please enter only positive integer.            | Quota is valid.                        |

**server-side validation of user inputs**

User with username "**slogin**" should have been added to table "account" and "customer" when testing login page.

| No.                                   | 1                                                            |
| ------------------------------------- | ------------------------------------------------------------ |
| **Description**                       | To test if username has been registered                      |
| **Input for "Set Username" text box** | slogin                                                       |
| **Input for "Set Password" text box** | 123456                                                       |
| **Input for "First Name" text box**   | Hebe                                                         |
| **Input for "Last Name" text box**    | Poy                                                          |
| **Input for "Region"**                | Thailand                                                     |
| **Input for "Telephone No" text box** | 38594830                                                     |
| **Input for "Email" text box**        | poy666@gmail.com                                             |
| **Input for "Set Quota" text box**    | 666                                                          |
| **Instruction**                       | click "**Assign salesrep**" button                           |
| **Expected output**                   | The username has been registered. Please change a username and try again.<br/>focus on "**Set Username**" text box |

**successful assign new salesrep**

| No.                                   | 1                                           |
| ------------------------------------- | ------------------------------------------- |
| **Description**                       | To test assign new salesrep successfully    |
| **Input for "Set Username" text box** | sthailand2                                  |
| **Input for "Set Password" text box** | 123456                                      |
| **Input for "First Name" text box**   | Hebe                                        |
| **Input for "Last Name" text box**    | Poy                                         |
| **Input for "Region"**                | Thailand                                    |
| **Input for "Telephone No" text box** | 38594830                                    |
| **Input for "Email" text box**        | [poy666@gmail.com](mailto:poy666@gmail.com) |
| **Input for "Set Quota" text box**    | 666                                         |
| **Instruction**                       | click "**Assign salesrep**" button          |
| **Expected output**                   | alert "Sales rep is successfully assigned." |

<h4>Modify Quota</h4>

click "**Modify quota**" hyperlink on the header

**src/manager/quota.php**

**View all salesreps' info**

| salesrep employee id | username   | first name | last name | region   | telephone   | email               | quota |
| -------------------- | ---------- | ---------- | --------- | -------- | ----------- | ------------------- | ----- |
| 1                    | slogin     | Carl       | Jones     | UK       | 38294065    | CarlJones@gmail.com | 850   |
| 2                    | schina1    | Yang       | Zhao      | China    | 13627488590 | yang-zhao@qq.com    | 1600  |
| 3                    | schina2    | Hua        | Li        | China    | 18294890023 | Hua-Li@qq.com       | 1450  |
| 4                    | sthailand1 | Ming       | Li        | Thailand | 13928446578 | ming.li@gmail.com   | 3200  |
| 5                    | suk1       | Annie      | Zhang     | UK       | 13728374993 | A-Zhang@outlook.com | 2740  |
| 6                    | skorea1    | Simon      | Chen      | Korea    | 18047283946 | Simon@outlook.com   | 2490  |
| 7                    | schina3    | Na         | Liu       | China    | 12738223940 | nana@163.com        | 4710  |
| 8                    | sthailand2 | Hebe       | Poy       | Thailand | 38594830    | poy666@gmail.com    | 666   |

Salesrep with **employee id 8** is newly assigned when testing "**Assign salesrep**".

**client-side validation of user inputs**

**Employee ID**

| No.                                  | 1                                                            | 2                                                | 3                                                | 4                                                | 5                                        |
| ------------------------------------ | ------------------------------------------------------------ | ------------------------------------------------ | ------------------------------------------------ | ------------------------------------------------ | ---------------------------------------- |
| **Description**                      | To test "**Employee ID**" text box cannot be empty           | To test if negative number is invalid            | To test if floating point number is invalid      | To test if chars other than digits are invalid   | To test valid input for employee ID      |
| **Input for "Employee ID" text box** | 8                                                            | -8                                               | 8.8                                              | sthailand2                                       | 8                                        |
| **Instruction**                      | lose focus on "**Employee ID**" text box<br/>**delete input**<br/>lose focus on "**Employee ID**" text box | lose focus on "**Employee ID**" text box         | lose focus on "**Employee ID**" text box         | lose focus on "**Employee ID**" text box         | lose focus on "**Employee ID**" text box |
| **Expected output**                  | Please enter an employee id of salesrep.                     | Please enter only valid employee id of salesrep. | Please enter only valid employee id of salesrep. | Please enter only valid employee id of salesrep. | Employee id is valid.                    |

**Quota**

| No.                            | 1                                                            | 2                                    | 3                                          | 4                                              | 5                                  |
| ------------------------------ | ------------------------------------------------------------ | ------------------------------------ | ------------------------------------------ | ---------------------------------------------- | ---------------------------------- |
| **Description**                | To test "**Quota**" text box cannot be empty                 | To test if negative input is invalid | To test if floating point input is invalid | To test if chars other than digits are invalid | To test valid input for quota      |
| **Input for "Quota" text box** | 6660                                                         | -6660                                | 666.0                                      | 666a                                           | 6660                               |
| **Instruction**                | lose focus on "**Quota**" text box<br/>**delete input**<br/>lose focus on "**Quota**" text box | lose focus on "**Quota**" text box   | lose focus on "**Quota**" text box         | lose focus on "**Quota**" text box             | lose focus on "**Quota**" text box |
| **Expected output**            | Please enter quota for salesrep.                             | Please enter only positive integer.  | Please enter only positive integer.        | Please enter only positive integer.            | Quota is valid.                    |

**server-side validation of user inputs**

| No.                                  | 1                                                            | 2                                                            |
| ------------------------------------ | ------------------------------------------------------------ | ------------------------------------------------------------ |
| **Description**                      | To test if employee ID/salesrep does not exist               | To test successful quota modification                        |
| **Input for "Employee ID" text box** | 100                                                          | 8                                                            |
| **Input for "Quota" text box**       | 6660                                                         | 6660                                                         |
| **Instruction**                      | click "**Modify quota**" button                              | click "**Modify quota**" button                              |
| **Expected output**                  | The salesrep does not exist.<br/>focus on "**Employee ID**" text box | alert "Quota for salesrep 8 is successfully modified to 6660."<br/>Quota for salesrep 8 is changed to 6660 in **"View all salesrep"** table. |

<h4>Modify Region</h4>

click "**Modify region**" hyperlink on the header

**src/manager/region.php**

**client-side validation of user inputs**

**Employee ID**

| No.                                  | 1                                                            | 2                                                | 3                                                | 4                                                | 5                                        |
| ------------------------------------ | ------------------------------------------------------------ | ------------------------------------------------ | ------------------------------------------------ | ------------------------------------------------ | ---------------------------------------- |
| **Description**                      | To test "**Employee ID**" text box cannot be empty           | To test if negative number is invalid            | To test if floating point number is invalid      | To test if chars other than digits are invalid   | To test valid input for employee ID      |
| **Input for "Employee ID" text box** | 1                                                            | -1                                               | 1.6                                              | slogin                                           | 1                                        |
| **Instruction**                      | lose focus on "**Employee ID**" text box<br/>**delete input**<br/>lose focus on "**Employee ID**" text box | lose focus on "**Employee ID**" text box         | lose focus on "**Employee ID**" text box         | lose focus on "**Employee ID**" text box         | lose focus on "**Employee ID**" text box |
| **Expected output**                  | Please enter an employee id of salesrep.                     | Please enter only valid employee id of salesrep. | Please enter only valid employee id of salesrep. | Please enter only valid employee id of salesrep. | Employee id is valid.                    |

**server-side validation of user inputs**

| No.                                  | 1                                                            | 2                                                            |
| ------------------------------------ | ------------------------------------------------------------ | ------------------------------------------------------------ |
| **Description**                      | To test if employee ID/salesrep does not exist               | To test successful region modification                       |
| **Input for "Employee ID" text box** | 100                                                          | 1                                                            |
| **Input for "Region" text box**      | Korea                                                        | Korea                                                        |
| **Instruction**                      | click "**Modify region**" button                             | click "**Modify region**" button                             |
| **Expected output**                  | The salesrep does not exist.<br/>focus on "**Employee ID**" text box | alert "Region for salesrep 1 is successfully modified to Korea."<br/>Region of salesrep 1 is changed to Korea in table. |

<h3>Customer</h3>

click "**Back**" hyperlink on the header

then click "**Customer**" hyperlink on the header

**src/manager/customer.php**

<h4>View all customers' info</h4>

| customer username | first name | last name | passport id | region | telephone   | email               |
| ----------------- | ---------- | --------- | ----------- | ------ | ----------- | ------------------- |
| cchina1           | Cassie     | Qiang     | E382950394  | UK     | 13538493049 | cassie.q@gmail.com  |
| cchina2           | Ellie      | Ma        | E402800391  | China  | 19383749923 | 3914872985@qq.com   |
| clogin            | Cole       | Smith     | 384759384   | UK     | 39574859    | ColeSmith@gmail.com |
| cregister         | Wing       | Wang      | E48394050   | China  | 13500000000 | wing-wang@gmail.com |

Region of "**cchina1**" is modified to UK when testing "**User Center**" of customer pages.

<h3>Statistic</h3>

click "**Statistic**" hyperlink on the header

<h4>Total</h4>

click "**Total**" button

**src/manager/sta_total.php**

**View total statistic**

It can be different if the process/inputs of the whole testing is not perfectly followed.

| total no. of masks sold (w/o anomalies) | total no. of masks sold (w/ anomalies) | total revenues |
| --------------------------------------- | -------------------------------------- | -------------- |
| 265                                     | 14000                                  | 2041.00        |

<h4>Salesrep</h4>

click "**Salesrep**" hyperlink on the header

**src/manager/sta_salesrep.php**

**View statistic of salesreps**

It can be different if the process/inputs of the whole testing is not perfectly followed.

| salesrep employee id | username   | sum of masks sold | sum of sales amount |
| -------------------- | ---------- | ----------------- | ------------------- |
| 1                    | slogin     | 45                | 846.00              |
| 2                    | schina1    | 170               | 255.00              |
| 3                    | schina2    | 50                | 940.00              |
| 4                    | sthailand1 | 0                 | 0                   |
| 5                    | suk1       | 0                 | 0                   |
| 6                    | skorea1    | 0                 | 0                   |
| 7                    | schina3    | 0                 | 0                   |
| 8                    | sthailand2 | 0                 | 0                   |

<h4>Region</h4>

Execute SQL statements

```mysql
-- insert some normal orders in China which will be in statistic
INSERT INTO `ordering` (`ordering_id`, `mask_type`, `quantity`, `sales_amount`, `creation_time`, `status`, `customer_username`, `salesrep_employee_id`) VALUES
(9, 'N95', 100, '1000.00', '2020-05-24 11:00:00', 'N', 'cchina2', 3),
(10, 'S', 125, '187.50', '2020-05-23 09:55:00', 'N', 'cchina2', 2),
(11, 'SN95', 90, '1692.00', '2020-05-20 18:35:00', 'N', 'cchina2', 7);

-- insert some anomaly orders in China which will not be in statistic
INSERT INTO `ordering` (`ordering_id`, `mask_type`, `quantity`, `sales_amount`, `creation_time`, `status`, `customer_username`, `salesrep_employee_id`) VALUES ('12', 'SN95', '4500', '84600', '2020-05-22 08:34:13', 'A', 'cchina2', '2');
```

click "**Region**" hyperlink on the header

**src/manager/sta_region.php**

**View statistic of regions**

| region   | sum of masks sold | sum of sales amount |
| -------- | ----------------- | ------------------- |
| China    | 315               | 2879.50             |
| Thailand | 0                 | 0                   |
| UK       | 265               | 2041.00             |
| Korea    | 0                 | 0                   |

<h4>Under ordering</h4>

click "**Under ordering**" hyperlink on the header

**src/manager/sta_under_ordering.php**

**View statistic of under ordering**

test date: 2020-05-24 16:40:00

It can be different because of time. If there's no orders within 24 hours, please insert some into the table "ordering" of the database. Here's only an example when I test.

| ordering id | mask type | quantity | sales amount | creation time       | status | customer username | salesrep employee id |
| ----------- | --------- | -------- | ------------ | ------------------- | ------ | ----------------- | -------------------- |
| 9           | N95       | 100      | 1000.00      | 2020-05-24 11:00:00 | N      | cchina2           | 3                    |

<h4>Week</h4>

Execute SQL statements

```mysql
-- insert some orders over 1 week
INSERT INTO `ordering` (`ordering_id`, `mask_type`, `quantity`, `sales_amount`, `creation_time`, `status`, `customer_username`, `salesrep_employee_id`) VALUES
(13, 'N95', 100, '1000.00', '2020-05-01 23:37:24', 'N', 'cchina2', 3),
(14, 'S', 100, '150.00', '2020-05-10 05:35:59', 'N', 'cchina2', 7),
(15, 'SN95', 100, '1880.00', '2020-05-15 16:19:12', 'N', 'cchina2', 2);
```

click "**Week**" hyperlink on the header

**src/manager/sta_week.php**

**View statistic of past 1 week**

test date: 2020-05-24 17:04:00

It can be different because of time. If there's no orders within 1 week, please insert some into the table "ordering" of the database. Here's only an example when I test.

| sum of masks sold | sum of sales amount | average of masks sold per order | average of sales amount per order | count of normal orders |
| ----------------- | ------------------- | ------------------------------- | --------------------------------- | ---------------------- |
| 580               | 4920.5              | 96.666666666667                 | 820.08333333333                   | 6                      |

<h4>Customer</h4>

click "**Customer**" hyperlink on the header

**src/manager/sta_customer.php**

**View statistic of customers**

It can be different if the whole process/inputs are not followed perfectly.

| customer username | sum of masks sold | sum of sales amount | average of masks sold | average of sales amount | count of orders |
| ----------------- | ----------------- | ------------------- | --------------------- | ----------------------- | --------------- |
| cchina1           | 220               | 1195.00             | 110.00                | 597.50                  | 2               |
| cchina2           | 615               | 5909.50             | 102.50                | 984.92                  | 6               |
| clogin            | 45                | 846.00              | 45.00                 | 846.00                  | 1               |
| cregister         | 0                 | 0                   | 0                     | 0                       | 0               |

Total no. of customers who have orders:  3                    

Total no. of customers:  4

[return to contents](#contents)