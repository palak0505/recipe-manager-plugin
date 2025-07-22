# Recipe Manager Plugin

A simple yet powerful WordPress plugin to manage and display recipes, featuring easy recipe creation in the admin and a unique frontend submission system for your users.

## ✨ Novelty & Key Feature: Frontend Recipe Submission

This plugin introduces a significant enhancement: **allowing logged-in users to submit their own recipes directly from the frontend of your website!**

All submitted recipes are automatically saved with a "Pending Review" status, giving site administrators full control to review, edit, and approve content before it goes live. This feature transforms your website into a dynamic, community-driven recipe platform, encouraging user engagement while maintaining content quality.

## 🚀 Features

* **Custom Post Type "Recipe":** Organizes all your recipes separately from standard posts and pages in a structured way.
* **Comprehensive Custom Meta Boxes:** Intuitive fields in the WordPress admin for capturing all essential recipe details:
    * Ingredients (supports multi-line lists)
    * Preparation Time
    * Cook Time
    * Serving Size
    * Difficulty Level (Easy, Medium, Hard dropdown)
    * Recipe Video URL (seamlessly embeds YouTube/Vimeo videos using WordPress's oEmbed)

* **User-Friendly Frontend Submission Form:** A simple shortcode `[recipe_submit_form]` can be placed on any page to render a form where logged-in users can submit new recipes directly.

    **Screenshot of Frontend Submission Form:**
    ![Frontend Submission Form](assets/screenshots/screenshot-frontend-form.png "Recipe Submission Form")

* **Robust Admin Review System:** All recipes submitted from the frontend are automatically marked as "Pending Review", ensuring administrators can moderate content before publishing.

    **Screenshot of Pending Recipes in Admin:**
    ![Pending Recipes in Admin](assets/screenshots/screenshot-pending-recipes.png "Pending Recipe Submissions")

* **Dedicated Single Recipe Template:** Displays all recipe details beautifully on the frontend, integrating seamlessly with your theme (via `single-recipe.php`).

    **Screenshot of a Published Recipe:**
    ![Published Recipe](assets/screenshots/screenshot-single-recipe.png "Frontend Display of a Recipe")

* **Essential Security Measures:** Implements WordPress Nonces for secure form submissions and restricts frontend submissions to logged-in users.

## 💻 Technologies Used

* PHP
* WordPress Core APIs (Custom Post Types, Meta Boxes API, Shortcode API, Actions & Filters, `wp_insert_post()`, `update_post_meta()`, `get_post_meta()`, `media_handle_upload()`, `wp_oembed_get()`, Nonces, Sanitization, User Permissions)
* HTML
* CSS (Implicitly)
* MySQL
* JavaScript

## 📦 Installation

1.  **Clone or Download:** Clone this GitHub repository using `git clone https://github.com/palak0505/recipe-manager-plugin.git` or download the ZIP file directly.
2.  **Upload the Plugin:**
    * If ZIP, go to WordPress Dashboard > Plugins > Add New > Upload Plugin, choose the ZIP, and install.
    * If cloned, upload the `recipe-manager-plugin` folder to your WordPress `wp-content/plugins/` directory via FTP/SFTP or your file manager.
3.  **Activate:** Go to WordPress Dashboard > Plugins > Installed Plugins and activate "Recipe Manager Plugin".
4.  **Flush Permalinks:** Navigate to WordPress Dashboard > Settings > Permalinks and click "Save Changes" (no actual changes needed) to ensure your new 'recipes' URLs work correctly.
5.  **Theme Integration:** Copy the `single-recipe.php` file from this project's root into your active WordPress theme's directory (e.g., `wp-content/themes/your-active-theme-name/`).
6.  **Create Submission Page:**
    * In your WordPress Admin, go to `Pages` > `Add New`.
    * Set the title (e.g., "Submit Your Recipe").
    * In the content area, add a "Shortcode" block and paste: `[recipe_submit_form]`
    * Publish the page.

## 🌐 Local Network Access (for XAMPP/WAMP/MAMP users)

If you are running WordPress on a local server (like XAMPP on Windows, WAMP on Windows, or MAMP on macOS) and want to access it from other devices on the **same local network** (e.g., your phone, another computer), you'll need to configure your local server and WordPress to use your computer's IP address instead of `localhost`.

**Prerequisite:** Both your server computer and the accessing device **must be connected to the exact same Wi-Fi network.**

### Steps to Enable Local Network Access:

1.  **Find Your Computer's Local IPv4 Address:**
    * **Windows:** Open Command Prompt (`cmd`), type `ipconfig`, and look for "IPv4 Address" under your active network adapter (e.g., Wi-Fi or Ethernet). It will look like `192.168.X.X` or `10.0.X.X`. **Write this IP down.**
    * **macOS:** Open System Settings > Network, select your active connection (Wi-Fi/Ethernet), and find your IP address.

2.  **Configure Apache to Allow External Connections:**
    * **Stop Apache** in your XAMPP/WAMP/MAMP control panel.
    * **Open Apache's main configuration file:**
        * **XAMPP:** Click "Config" next to Apache in the XAMPP Control Panel, then select `Apache (httpd.conf)`.
        * **WAMP/MAMP:** Locate `httpd.conf` in your Apache installation directory (e.g., `wamp/bin/apache/apache[version]/conf/httpd.conf`).
    * **Find the main `DocumentRoot` and `<Directory>` block:**
        * Search for `DocumentRoot "C:/xampp/htdocs"` (or similar path for WAMP/MAMP).
        * Below that, locate the `<Directory "C:/xampp/htdocs">` block.
        * **Inside this `<Directory>` block**, find `Require local` or `Require ip 127.0.0.1` and **change it to:**
            ```apache
            Require all granted
            ```
    * **Save** the `httpd.conf` file.
    * **Start Apache** again in your control panel.

3.  **Update WordPress Site URLs in `wp-config.php`:**
    * **Open `wp-config.php`** located in your WordPress root directory (e.g., `C:\xampp\htdocs\myblog\wp-content\plugins\your-plugin-name\wp-config.php`).
    * **Add these two lines** right before the line `/* That's all, stop editing! Happy publishing. */`:
        ```php
        define('WP_HOME','http://YOUR_ACTUAL_IP_ADDRESS/myblog');
        define('WP_SITEURL','http://YOUR_ACTUAL_IP_ADDRESS/myblog');
        ```
        **Replace `YOUR_ACTUAL_IP_ADDRESS`** with the exact IPv4 address you found in Step 1.
    * **Save** `wp-config.php`.


4.  **Access from Your Device:**
    * On your phone or other device, open your browser.
    * **Explicitly type `http://`** followed by your computer's IP address and your WordPress folder name:
        `http://YOUR_ACTUAL_IP_ADDRESS/myblog/`
 
