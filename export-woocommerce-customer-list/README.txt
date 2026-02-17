=== PiWeb Export Customers Users & Guest customer to CSV for WooCommerce  ===
Contributors: rajeshsingh520
Donate link: http://piwebsolution.com
Tags: Customer list, Export user, Export users, User export, usermeta, Export customer, users, customer csv, export guest, guest csv
Requires at least: 3.0.1
Tested up to: 6.9
Stable tag: 2.2.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Export WooCommerce customer list CSV, export WooCommerce guest customer list CSV, export WordPress users CSV, Product Customer List for WooCommerce

== Description ==

Export WooCommerce customer list or export users with one click.

* Download <strong>complete customer</strong> list 
* Download customer list by <strong>skipping rows</strong> from the top
* <strong>Limit the number of customer</strong> list rows in the exported CSV
* <strong>Modify the fields</strong> that you want in the generated CSV
* You can <strong>save the fields</strong> needed in the CSV so you don't have to do this again; from next time onwards, you can directly click download
* <strong>Automate</strong> the whole customer list exporting process and receive the customer list in your inbox
* <strong>Set the email ID</strong> on which you want to receive the email
* Export customer user meta data

https://www.youtube.com/watch?v=_tREXIJk96Y&cc_load_policy=1

== PRO Version ==
Here are the features of the PRO version of Export customer list:

[Buy PRO version, Limited-period offer](https://www.piwebsolution.com/product/export-woocommerce-customer-list/) | [Documentation](https://www.piwebsolution.com/user-documentation-export-customer-list-for-woocommerce/)

* All the features of the FREE version
* It allows you to download customers based on their <strong>registration dates</strong>
* It allows you to give <strong>custom labels to the columns</strong> of the generated CSV
* You can download users based on the <strong>registration date range</strong>
* You can set <strong>frequency of the automated email</strong>, to be Hourly, Twice Daily, Daily, or Weekly
* The list that you will receive will contain only the users registered during this time period
* You can download <strong>Guest customer</strong> data in a separate CSV
* You can filter out the guest customer list based on their <strong>order status</strong>
* You can filter out the guest customer list based on their <strong>order placement date</strong>
* **Export users:** You can download any other registered user data by <strong>selecting their role</strong>, so now you can download WooCommerce customer or normal WordPress user data as well
* Download customer records based on the **product they have purchased** 
* You can make a condition for downloading the Product Customer List of only those customers who purchased product A and product B together in a single order
* You can control the fields you want to download in the Product Customer List records
* You can restrict the Product Customer List by **date of purchase or order status** as well

* This plugin can export custom data fields stored in:
User meta data, stored in the xx_usermeta table
Order meta data, stored in the xx_postmeta table
For registered customers: The plugin first tries to search for the custom field in user meta data, and if it is not found there, then it searches order meta data to find the value
For guest customers: It directly searches order meta data for the custom field data

* You can receive registered customer, **guest customer** or both customer records in email attachments

== Frequently Asked Questions ==
= I just installed the plugin; I can't find its settings page =
You can find its download page or options page in 
**Tools >> Export customer**

= I want all the WooCommerce customer fields in the exported CSV =
Yes, just click the Download button; it will contain all the fields of the WooCommerce customer

= Can I save the fields I need in the exported CSV = 
Yes, you can save the fields needed, so next time when you download, only the selected fields will be exported to the CSV

= Can I modify the label of the exported CSV fields =
Yes, in the PRO version you can modify the field labels and save them too, so when you download the CSV it will have the modified fields. That way, you can directly use this CSV in your external system

= I want to receive the exported customer CSV via email =
Yes, you can do this. Just enter your email and it will send the exported CSV list as an attachment via email twice daily, and the list will contain all the customers on your site

= I don't want to receive emails twice daily, can I change the frequency of the email =
Yes, in the PRO version you can change the frequency of the customer list email that you receive. You can set the frequency to be Hourly, Twice Daily, Daily, or Weekly

= The CSV that I receive contains all the customers on my site, can I receive customers registered in that time interval =
Yes, in the PRO version you will only receive the customers registered during that particular time interval. So if you have set Weekly, you will receive one email at an interval of 7 days, and it will contain a list of customers registered during that 7-day interval

= I want to modify the subject and the message of the email =
The PRO version allows you to change the subject and message of the email

= I want to change the delimiter used in the CSV file = 
Yes, you can do that in the PRO version for the downloading part

= I don't allow customer registration on the site, all do guest checkout =
There is an option to download guest customers as well. In the free version, it will download only 30 at a time; in the PRO version, you can export customers from WooCommerce in one CSV

= Columns option doesn't work on the guest customer CSV =
You can't modify the columns option in the guest CSV; field modification only works for the registered customer CSV

= Guest customer data can have repeated customer details =
Yes, as it is extracted from the orders placed by the customer, so if a customer has placed multiple orders, then their record will repeat in the CSV

= I want to download all the guest customers whose order status is processing =
Yes, you can do that in the PRO version. The PRO version allows you to download guest customers based on their WooCommerce order status

= I want to export customers from WooCommerce, all at once =
In the PRO version you can do that for registered customers; just leave the 'Registration done between' field empty and it will get all customers from WooCommerce 

= If you want to download WordPress users, that is export users other than customers =
You can do so in the PRO version; it allows you to select the user role whose records you would like to download

= I am using a plugin for WhatsApp number, I want to download that from the CSV (Registered user) =
In the Pro version, there is an option that allows you to add extra user meta fields in the list of rows to extract in the CSV. Using this option, you can add an extra field that you want to extract (we have given you the list of WooCommerce meta fields)
Step 1: Get the name of the user meta field that you want to add in the CSV (and make sure that field is not present in our given list)
Step 2: Add that name in the left-side form
Step 3: Go to the 'Select field to add in CSV'
Step 4: Your added field will appear in the list; select it and save it

= I want to send the guest customer report as an attachment =
The PRO version allows you to select which report you want to receive; you can receive registered customer, guest customer, or both customer details in an email attachment (CSV)

= We want to export some custom data from a plugin but it is not exporting values (PRO) =
This plugin can export custom data fields stored in:
User meta data, stored in the xx_usermeta table
Order meta data, stored in the xx_postmeta table
so confirm with the plugin developer whose data you want to export how they have stored that data.

For registered customers: The plugin first tries to search for the custom field in user meta data, and if it is not found there, then it searches order meta data to find the value
For guest customers: It directly searches order meta data for the custom field data

= We want to download customers who purchased a specific product =
That can be done in the PRO version

= Is it HPOS compatible =
Yes, the free version and PRO version both are HPOS compatible

== Screenshots ==
1. Exporting registered customer list by export WooCommerce customer list plugin
2. Configure field to be exported
3. Option to include custom order meta data in export WooCommerce customer list plugin
4. Exporting guest customer list 
5. Sending customer list in email attachment automatically using export WooCommerce customer list plugin
6. Sending customer list in email attachment automatically 

== Changelog ==

= 2.1.77 =
* code optimized for customer list export

= 2.1.76 =
* Tested with WC 10.0.2

= 2.1.74 =
* Export customer list WooCommerce plugin tested for WC 9.9.5
* UI improved for export customer list WooCommerce plugin

= 2.1.73 =
* Export customer list WooCommerce plugin tested for WC 9.9.3

= 2.1.72 =
* Tested with WC 9.8.0

= 2.1.71 =
* Translation warning fixed

= 2.1.70 =
* Tested with WC 9.7.1

= 2.1.69 =
* Tested with WC 9.7.0

= 2.1.67 =
* Tested with WC 9.6.2

= 2.1.66 =
* Tested with WC 9.6.0

= 2.1.60 =
* Tested with WC 9.4.0

= 2.1.49 =
* Tested with WP 6.7.0

= 2.1.46 =
* Tested with WC 9.3.0

= 2.1.44 =
* Tested with WC 9.2.3

= 2.1.43 =
* Calendar fixed
* Limit on extraction of guest customers removed in the free version

= 2.1.42 =
* Tested with WC 9.2.0

= 2.1.40 =
* Tested with WordPress 6.6.1

= 2.1.19 =
* Compatible with PHP 8.2

= 2.0.79 =
* Backend CSS changes

== Privacy ==

If you choose to opt in from the plugin settings, or submit optional feedback during deactivation, this plugin may collect basic technical information, including:

- Plugin version  
- WordPress version  
- WooCommerce version  
- Site URL
- Deactivation reason (if submitted)

This data is used solely to improve plugin quality, compatibility, and features. No personal or user-specific data is collected without consent.