=== Recipe Manager Plugin ===
Contributors: yourgithubusername
Tags: recipe, food, cooking, custom post type, frontend submission, shortcode, metabox
Requires at least: 5.8
Tested up to: 6.5
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A simple yet powerful WordPress plugin to manage and display recipes, featuring easy recipe creation in the admin and a unique frontend submission system for your users.

== Description ==

The Recipe Manager Plugin empowers WordPress users to easily create and manage a dedicated collection of recipes. It introduces a custom 'Recipe' post type with custom fields for ingredients, preparation time, cook time, serving size, difficulty, and a video URL.

**Novelty & Key Feature: Frontend Recipe Submission**
This plugin uniquely allows **logged-in users to submit their own recipes directly from the frontend of your website.** Submitted recipes are automatically set to "Pending Review" status, giving site administrators full control to approve and publish content, ensuring quality and preventing spam. This feature transforms your site into a community-driven recipe platform.

**Features:**
* **Custom Post Type "Recipe":** Organize your recipes separate from standard posts and pages.
* **Custom Meta Boxes:** Dedicated fields in the WordPress admin for:
    * Ingredients (multi-line)
    * Preparation Time
    * Cook Time
    * Serving Size
    * Difficulty (Easy, Medium, Hard)
    * Recipe Video URL (supports YouTube/Vimeo embeds)
* **Frontend Submission Form:** A simple shortcode `[recipe_submit_form]` renders a form where logged-in users can submit new recipes.
* **Admin Review System:** All frontend submissions are set to "Pending Review" status, requiring administrator approval before being published.
* **Custom Single Recipe Template:** Displays all recipe details beautifully on the frontend (requires `single-recipe.php` in your theme).
* **Basic Security Measures:** Includes nonces for form submissions and checks for user login status.

== Installation ==

1.  **Upload the Plugin:**
    * Download the plugin ZIP file from GitHub.
    * Go to your WordPress Dashboard > Plugins > Add New > Upload Plugin.
    * Choose the downloaded ZIP file and click "Install Now".
    * Alternatively, upload the `your-recipe-manager-plugin` folder to the `/wp-content/plugins/` directory via FTP.
2.  **Activate the Plugin:** After uploading, go to Plugins > Installed Plugins and click "Activate" next to "Recipe Manager Plugin".
3.  **Flush Permalinks:** Go to Settings > Permalinks and simply click "Save Changes" (without making any changes) to ensure the new 'recipe' permalinks work correctly.
4.  **Add Theme Template:** Copy the `single-recipe.php` file (provided in the project) into your active theme's directory (e.g., `wp-content/themes/twentytwentyfive/`).
5.  **Create Submission Page:**
    * Go to Pages > Add New.
    * Give the page a title (e.g., "Submit Your Recipe").
    * In the content area, add the Shortcode block and enter: `[recipe_submit_form]`
    * Publish the page.

**For Local XAMPP/WAMP/MAMP Setup:**
If you are testing this plugin on a local server (like XAMPP), you might need to adjust your Apache configuration and `wp-config.php` to access it from other devices on your local network. Refer to the `README.md` file in the GitHub repository for detailed instructions.

== Usage ==

**1. Creating Recipes (Admin Area):**
* Go to "Recipes" in your WordPress admin menu.
* Click "Add New" to create a new recipe.
* Fill in the title, main content (for instructions/description), and use the "Recipe Details" meta box to add ingredients, times, serving size, difficulty, and video URL.
* Set a featured image if desired.
* Publish your recipe.

**2. Frontend Recipe Submission (For Users):**
* Direct your logged-in users to the page where you placed the `[recipe_submit_form]` shortcode (e.g., "Submit Your Recipe" page).
* They can fill out the form and submit their recipe.
* All submissions will appear in your WordPress admin under "Recipes" with a "Pending Review" status.

**3. Reviewing Submissions:**
* As an administrator, go to "Recipes > All Recipes".
* You will see new submissions marked as "Pending".
* Edit the recipe to review its content.
* Once satisfied, change its status from "Pending" to "Published" and update the post.

== Frequently Asked Questions ==

* **Q: Can guest users submit recipes?**
    A: No, for security and spam prevention, only logged-in users can submit recipes via the frontend form.
* **Q: Where do submitted recipes go?**
    A: All frontend submissions are created as "Pending Review" posts under the "Recipes" custom post type, visible only to administrators in the backend.

== Changelog ==

= 1.0.0 =
* Initial release of the Recipe Manager Plugin.
* Introduced Custom Post Type for Recipes.
* Implemented custom meta boxes for recipe details.
* Added `[recipe_submit_form]` shortcode for frontend recipe submission.
* Integrated admin review process for submitted recipes.
* Provided `single-recipe.php` template for frontend display.