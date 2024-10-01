=== Export customers list csv for WooCommerce, WordPress users csv, export Guest customer list ===
Contributors: rajeshsingh520
Donate link: http://piwebsolution.com
Tags: Customer list, Export user, Export users, User export, usermeta, Export customer, users, customer csv, export guest, guest csv
Requires at least: 3.0.1
Tested up to: 6.6.1
Stable tag: 2.1.46
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Export WooCommerce customers list csv, Export WooCommerce guest customer list csv, Export WordPress users csv, Product Customer List for WooCommerce

== Description ==

Export WooCommerce customers list or Export users with one click, 

* Download <strong>Complete customer</strong> list 
* Download customer list, by <strong>skipping rows</strong> from top
* <strong>Limit the number of Customer</strong> list rows in the exported CSV
* <strong>Modify the fields</strong> that you want in the generated CSV
* You can <strong>save the field</strong> needed in CSV so you don't have to do this again, and from next time onwards you can directly click download
* <strong>Automate</strong> the whole customer list exporting process, and receive the customer list in your inbox
* <strong>Set email id</strong> on which you want to receive the email
* Export customer usermeta data

https://www.youtube.com/watch?v=_tREXIJk96Y&cc_load_policy=1

== PRO Version ==
Here are the features of the PRO version of Export customer list:

[Buy PRO version, Limited period offer](https://www.piwebsolution.com/product/export-woocommerce-customer-list/)

* All the features of the FREE version
* It allows you to download customer based on there <strong>registration dates</strong>
* It allow you to give <strong>custom labels to the columns</strong> of the generated CSV
* You can download users based on the <strong>registration date range</strong>
* You can set <strong>frequency of the automated email</strong>, to be Hourly, Twice Daily, Daily, Weekly
* The list that you will receive will contain only the user registered during this time period
* You can download <strong>Guest customer</strong> data in separate CSV
* You can filter out guest customer list based on there <strong>order status</strong>
* You can filter out guest customer list based on there <strong>order placement date</strong>
* **Export users:** You can download any other registered customer date by <strong>selecting there role</strong>, so now you cna download WooCommerce customer plugin normal WordPress user data as well
* Download customer record based on the **product they have purchased** 
* You can make a condition of downloading Product Customer List of only those customer who purchased product A and product B together in single order
* You can control the fields you want to download in Product Customer List record
* You can restrict the Product Customer List by **date of purchase or order status** as well

* This plugin can export custom data field stored in:
User meta data, stored in xx_usermeta table
Order meta data, stored in xx_postmeta table
For Registered Customer: Plugin first tries to search for the custom field in user meta data and if it is not found there then it searches order meta data to find the value
For Guest customer: It directly searches order meta for the custom field data

* You can receive Registered customer, **guest customer** or both customer record in email attachment

== Frequently Asked Questions ==
= I just installed the plugin, I can't find it's setting page =
You can find its download page or options page in 
**Tools >> Export customer**

= I want all the WooCommerce customer fields in the exported CSV =
Yes, just click the download button it will contain all the fields of the WooCommerce customer

= Can I save the fields I need in the exported CSV = 
Yes, you can save the fields needed, so next time when you will download only the selected field will be exported to the csv

= Can I modify the label of the exported CSV fields =
Yes, In the PRO version you can modify the field labels and save it too, so when you will download the CSV it will have the modified fields that way you can directly use this csv in your external system

= I want to receive the exported customer CSV in email =
Yes, you can do this, just enter your email and it will send exported csv list as an attachment in the email twice daily. and the list will contain all the customers in your site

= I don't want to receive emails Twice daily, can I change the frequency of the email =
Yes, In the PRO version you can change the frequency of the customer list email that you receive. You can set the frequency to be Hourly, Twice Daily, Daily, or Weekly

= CSV that I receive contains all the customer in my site, can I receive customer registered in that time interval =
Yes, In the pro version you will only receive the customer registered during that particular time interval. So if you have set the Weekly, you will receive one email at an interval of 7 days and will contain a list of customer registered curing that interval of 7 days

= I want to modify the subject and the message of the email =
PRO version allows you to change the subject and message of the email

= I want to change the delimiter used in the CSV file = 
Yes you can do that in the pro version for the downloading part

= I don't allow customer registration on site, all do guest checkout =
There is an option to download guest customer as well, in the free version it will download 30 at a time only, in the PRO version you can export customer from WooCommerce in one CSV

= Columns option don't work on the guest customer csv =
you can't modify columns option in the Gust csv, field modification only works for the registered customer csv

= Guest customer date can have repeating customer detail =
Yes, as it is extracted from the order placed by the customer, so if some customer has placed multiple orders then there record will repeat in the CSV

= I want to download all the guest customer whose order status is processing =
Yes you can do that in the pro version, pro version allows you to download guest customer based on their WooCommerce Order status

= I want to export customers from WooCommerce, all at once =
In the pro version you can do that for the registered customer, just leave the "Registration done between field empty and it will get all customers from WooCommerce 

= If you want to download WordPress user, that is export users other then customer =
You can do so in the PRO version it allows you to select the user role whose record you will like to download

= I am using a plugin WhatsApp number, I want to download that from the CSV (Registered user) =
In the Pro version, there is an option that allows you to add extra user meta field in the list of rows to extract in the CSV, using this option you can add an extra field that you want to extract, (We have given you the list WooCommerce meta fields)
Step 1: Get the name of the user meta field that you want to add in csv (and make sure that field is not present in our given list)
Step 2: Add that name on the left side form
Step 3: Go to the "select field to add in CSV"
Step 4: Your added field will appear in the list, select it and save it

= I want to send guest customer report in attachment =
Pro version allows you to select which report you want to receive, you can receive Registered customer, Guest customer, or both the customer detail in email attachment csv

= We want to export some custom date from a plugin but it is not exporting value (pro) =
This plugin can export custom data field stored in:
User meta data, stored in xx_usermeta table
Order meta data, stored in xx_postmeta table
so do confirm with the plugin developer whose data you want to export how they have stored those data.

For Registered Customer: Plugin first tryes to search for the custom field in user meta data and if it is not found there then it searches order meta data to find the value
For Guest customer: It directly searches order meta for the custom field data

= We want to download customer who purchases some specific product =
That can be done in the pro version

= Is it HPOS compatible =
Yes the Free version and PRO version both are HPOS compatible

== Changelog ==

= 2.1.46 =
* Tested with WC 9.3.0

= 2.1.44 =
* Tested with WC 9.2.3

= 2.1.43 =
* calendar fixed
* limit on extraction of guest customer removed in the free version

= 2.1.42 =
* Tested with WC 9.2.0

= 2.1.40 =
* Tested with WordPress 6.6.1

= 2.1.19 =
* Compatible with PHP 8.2

= 2.0.79 =
* Backend css changes