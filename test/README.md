# README

<a name="contents"></a>

## Contents

* [Guidance](#guidance)

* [Flowcharts](#flowcharts)
- [Customer](#customer)

- [Salesrep](#salesrep)
  
- [Manager](#manager)



<a name="guidance"></a>

## Guidance

1. Download zip file from Moodle

2. Put it inside public_html folder

3. Open database using url on browser Google or Firefox: 

   http://cslinux.nottingham.edu.cn/phpmyadmin/

   username: scyqw4

   password: scyqw4

   dbname: scyqw4

   Delete all tables in db "scyqw4" if there's any.

4. Import my SQL script in "src" folder, import it into db "scyqw4"

5. Open my cw using url on browser Google or Firefox:

   http://cslinux.nottingham.edu.cn/~scyqw4/20124865_Qingyu_WANG/src/login.html

6. Start with "Test Data.md" in "test" folder, follow detailed instructions in it to test my cw.

[return to contents](#contents)



<a name="flowcharts"></a>

## Flowcharts

**Attention**

This part has some overlaps with the "**Walk through of SMS**" in **Reference.pdf**. Therefore, please refer to "Walk through of SMS" in Reference for **detailed description of each pages**!

All the functionalities that are shown below match my actual design, however, the data on each page that is obtained from database can be different.

All the data shown in the screenshots are the data remained in database **after** test using **Test Data.md**.

<a name="customer"></a>

## Customer

<h4>flowchart</h4>

![flowchart-customer](image/flowchart-customer.png)

<h4>step 1</h4>

**Register**

src/register.html

![register](image/register.png)

<h4>step 2</h4>

If **register successfully**, it can jump to login page: **src/login.html**.

**login**

![login](image/login.png)

username: clogin

password: 123456

**This account is added into database when test login page using "Test Data.md".**

<h4>step 3</h4>

If **login successfully**, it can jump to "Home page": **src/customer/customer.php**.

**Order masks**

![home-page](image/home-page.png)

<h4>step 4</h4>

Click **User Center** on the header to jump to "User Center": **src/customer/user_center.html**.

**Authenticate password**

![user-center](image/user-center.png)

password: 123456

<h4>step 5</h4>

If **authenticate successfully**, jump to "Modify your information": **src/customer/modify_info.html**.

**Modify information**

![modify-info](image/modify-info.png)

<h4>step 6</h4>

If **click "Cancel"** or **modify info successfully**, it can jump back to "Home Page": **src/customer/customer.php**.

![home-page](image/home-page.png)

<h4>step 7</h4>

**Click "Orders"**, it can jump to "Orders": **src/customer/customer_orders.php**.

**View orders and Delete orders**

![customer-orders](image/customer-orders.png)

<h4>step 8</h4>

Click "Login/Logout", if **logout successfully**, jump to login page: **cw/src/login.html**

**Logout**

![login](image/login.png)

[return to contents](#contents)



<a name="salesrep"></a>

## Salesrep

**flowchart**

![flowchart-salesrep](image/flowchart-salesrep.png)

<h4>step 1</h4>

**Login**

cw/src/login.html

username: slogin

password: 123456

**This account is added into database when testing login page using "Test Data.md".**

![login](image/login.png)

<h4>step 2</h4>

If **login successfully**, it can jump to "Orders": **src/salesrep/salesrep.php**.

**View all orders with customer info and Delete orders with anomalies within 24 hours**

![salesrep-orders](image/salesrep-orders.png)

<h4>step 3</h4>

If **click "Info"** on the header, it can jump to "Info": **src/salesrep/view_quota.php**.

**View personal info**

![salesrep-info](image/salesrep-info.png)

<h4>step 4</h4>

Click "Login/Logout" button, if **logout successfully**, it can jump to login page: **src/login.html**.

**Logout**

![login](image/login.png)

[return to contents](#contents)



<a name="manager"></a>

## Manager

<h4>flowchart</h4>

![flowchart-manager](image/flowchart-manager.png)

<h4>step 1</h4>

**login**

username: manager

password: 123456

![login](image/login.png)

<h4>step 2</h4>

If **login successfully**, it can jump to "Anomaly": **src/manager/manager.php**.

**View orders with anomalies over 24 hours**

![manager-anomaly](image/manager-anomaly.png)

<h4>step 2</h4>

If **click "Order"** on the header, it can jump to "Order": **src/manager/order.php**.

**View all orders**

![manager-order](image/manager-order.png)

<h4>step 3</h4>

If **click "Salesrep"**, it can jump to "Salesrep": **src/manager/salesrep.html**.

**Operate on salesrep**

![manager-salesrep](image/manager-salesrep.png)

<h4>step 4</h4>

If **click "Assign salesrep"**, it can jump to "Assign new salesrep": **src/manager/assign_salesrep.html**.

**Assign new salesrep**

![assign-salesrep](image/assign-salesrep.png)

<h4>step 5</h4>

If **click "Modify region"** on the header, it can jump to "Modify region": **src/manager/region.php**.

**View salesrep info and Modify region**

![modify-region](image/modify-region.png)

<h4>step 6</h4>

If **click "Modify quota"** on the header, it can jump to "Modify quota": **src/manager/quota.php**.

**View salesrep info and Modify quota**

![modify-quota](image/modify-quota.png)

<h4>step 7</h4>

If **click "Back"** on the header, it can jump to "Salesrep": **src/manager/salesrep.html**.

![manager-salesrep](image/manager-salesrep.png)

<h4>step 8</h4>

If **click "Customer"** on the header, it can jump to "Customer": **src/manager/customer.php**.

**View customer info**

![manager-customer](image/manager-customer.png)

<h4>step 9</h4>

If **click "Statistics"** on the header, it can jump to "Statistics": **src/manager/statistics.html**.

**View statistics**

![statistics](image/statistics.png)

**Attention**: step 10 - step 15 are not included in flowchart as all of them are statistics, only contents are different! 

<h4>step 10</h4>

If **click "Total" button**, it can jump to "Total": **src/manager/sta_total.php**.

**View statistics of total**

![sta-total](image/sta-total.png)



<h4>step 11</h4>

If **click "Salesrep"** on the header, it can jump to "Salesrep": **src/manager/sta_salesrep.php**.

**View statistics of salesreps**

![sta-salesrep](image/sta-salesrep.png)

<h4>step 12</h4>

If **click "Region"** on the header, it can jump to "Region": **src/manager/sta_region.php**.

**View statistics of regions**

![sta-region](image/sta-region.png)

<h4>step 13</h4>

If **click "Under ordering"** on the header, it can jump to "Under ordering": **src/manager/sta_under_ordering.php**.

**View masks under ordering**

![sta-under-ordering](image/sta-under-ordering.png)



<h4>step 14</h4>

If **click "Week"** on the header, it can jump to "Week": **src/manager/sta_week.php**.

**View statistics within 1 week**

![sta-week](image/sta-week.png)



<h4>step 15</h4>

If **click "Customer"** on the header, it can jump to "Customer": **src/manager/sta_customer.php**.

**View statistics of customers**

![sta-customer](image/sta-customer.png)

<h4>step 16</h4>

If **click "Back"** on the header, it can jump to "Statistics": **src/manager/statistics.html**.

![statistics](image/statistics.png)

<h4>step 17</h4>

Click "Login/logout" on the header, if **logout successfully**, it can jump to login page: **src/login.html**.

**Logout**

![login](image/login.png)

[return to contents](#contents)