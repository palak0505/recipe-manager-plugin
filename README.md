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

    **Screenshot of Recipe Meta Boxes in Admin:**
    ` ![Recipe Meta Boxes](assets/screenshots/screenshot-admin-recipe.png "Recipe Details Meta Box") `

* **User-Friendly Frontend Submission Form:** A simple shortcode `[[recipe_submit_form]]` can be placed on any page to render a form where logged-in users can submit new recipes directly.

    **Screenshot of Frontend Submission Form:**
    ` ![Frontend Submission Form](assets/screenshots/screenshot-frontend-form.png "Recipe Submission Form") `

* **Robust Admin Review System:** All recipes submitted from the frontend are automatically marked as "Pending Review", ensuring administrators can moderate content before publishing.

    **Screenshot of Pending Recipes in Admin:**
    ` ![Pending Recipes in Admin](assets/screenshots/screenshot-pending-recipes.png "Pending Recipe Submissions") `

* **Dedicated Single Recipe Template:** Displays all recipe details beautifully on the frontend, integrating seamlessly with your theme (via `single-recipe.php`).

    **Screenshot of a Published Recipe:**
    ` ![Published Recipe](assets/screenshots/screenshot-single-recipe.png "Frontend Display of a Recipe") `

* **Essential Security Measures:** Implements WordPress Nonces for secure form submissions and restricts frontend submissions to logged-in users.

## 💻 Technologies Used

* PHP
* WordPress Core APIs (Custom Post Types, Meta Boxes API, Shortcode API, Actions & Filters, `wp_insert_post()`, `update_post_meta()`, `get_post_meta()`, `media_handle_upload()`, `wp_oembed_get()`, Nonces, Sanitization, User Permissions)
* HTML
* CSS (Implicitly)
* MySQL
* Javascript

## 📦 Installation

1.  **https://github.com/palak0505/recipe-manager-plugin.git:** Clone this GitHub repository or download the ZIP file.
## 🌐 Local Network Access (for XAMPP/WAMP/MAMP users)

...(Local Network Access instructions remain the same)

## 📝 Usage

Refer to the "Features" section above for detailed usage of the admin interface and frontend submission.

## 🛣️ Future Enhancements (Ideas for further development)

...(Future Enhancements remain the same)

---