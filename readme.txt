Recipe Manager Plugin 
Contributors: palak0505
Tags: recipe, food, cooking, custom post type, frontend submission, shortcode, metabox
Requires at least: 5.8
Tested up to: 6.5
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A simple yet powerful WordPress plugin to manage and display recipes, featuring easy recipe creation in the admin and a unique frontend submission system for your users.

 Description

The Recipe Manager Plugin empowers WordPress users to easily create and manage a dedicated collection of recipes. It introduces a custom 'Recipe' post type with custom fields for ingredients, preparation time, cook time, serving size, difficulty, and a video URL.

Novelty & Key Feature: Frontend Recipe Submission
This plugin uniquely allows logged-in users to submit their own recipes directly from the frontend of your website. Submitted recipes are automatically set to "Pending Review" status, giving site administrators full control to approve and publish content, ensuring quality and preventing spam. This feature transforms your site into a community-driven recipe platform.

Features:
Custom Post Type "Recipe": Organize your recipes separate from standard posts and pages.
Custom Meta Boxes:** Dedicated fields in the WordPress admin for:
    Ingredients (multi-line)
    Preparation Time
    Cook Time
    Serving Size
    Difficulty (Easy, Medium, Hard)
    Recipe Video URL (supports YouTube/Vimeo embeds)
Frontend Submission Form:A simple shortcode `[recipe_submit_form]` renders a form where logged-in users can submit new recipes.
Admin Review System:All frontend submissions are set to "Pending Review" status, requiring administrator approval before being published.
Custom Single Recipe Template: Displays all recipe details beautifully on the frontend (requires `single-recipe.php` in your theme).
Basic Security Measures: Includes nonces for form submissions and checks for user login status.

