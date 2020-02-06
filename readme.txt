=== PWACommerce - WooCommerce Mobile Plugin for Progressive Web Apps & Hybrid Mobile Apps ===
Contributors: cborodescu, anghelalexandra, abarbulescu
Tags: pwa, progressive web apps, react, redux, semantic ui, rest api, android, iOS, html5, iphone, mobile, mobile web app, safari, smartphone, webkit, app builder, apple, apps, convert to app, create e-commerce app, ios app, make an app, mobile app plugin, mobile application, mobile woocommerce app, mobile plugin, ecommerce app theme, woocommerce to mobile app, woocommerce android, woocommerce app, woocommerce iphone, woocommerce mobile, woocommerce mobile app
Requires at least: 4.8
Tested up to: 5.3.2
Stable tag: 0.5.1
Requires PHP: 5.4
License: GPLv2 or later

[PWACommerce](https://pwacommerce.com) is a mobile plugin that helps you transform your WooCommerce shop into a progressive mobile web application.

== Description ==

**FEB 2020 UPDATE: A NEW & RESPONSIVE PWACOMMERCE THEME IS COMING SOON! STAY TUNED AT [PWACOMMERCE.COM](https://pwacommerce.com)**

---

**[PWACommerce](https://pwacommerce.com) is a mobile plugin that helps you transform your WooCommerce shop into a progressive mobile web application implemented with React, Redux and Semantic UI. It comes with multiple ecommerce app themes that you can purchase individually or as a bundle.**

PWACommerce is **supported on** iOS and Android smartphones and tablets. **Compatible browsers**: Safari, Google Chrome, Android - Native Browser.

It has been tested on WordPress 5.3.2 and later.

What PWACommerce enables you to do:

**Progressive Web Apps**

Some of the key features of progressive web apps are:

* **Add to Homescreen**. Readers can add the mobile web application to their homescreen and run it in full-screen mode, making it easy to launch and return to your app.
* Smooth animations, scrolling, and navigations keep the experience silky smooth.
* **Responsive UI**. The mobile web application is sensitive to various screen sizes and orientation changes: landscape, portrait. In other words, the look and feel of the mobile web app seamlessly morphs into the screen size of users' devices.
* **App Themes**. You can offer your users an exceptional buying experience by giving them a mobile web application with a native app-like look & feel. The default theme comes with basic features/options, but more app themes will be made available at [PWACommerce.com](https://pwacommerce.com).
* **Analytics**. PWACommerce easily integrates with Google Analytics.

PWACommerce also comes with a **PRO version** suitable for online stores that want to take full advantage of the Progressive Web App technology and increase engagement and conversions. Some of the benefits of using [PWACommerce.com](https://pwacommerce.com) are:

* **Offline Mode**. The app's shell and content is cached using service workers. Categories and products are saved in the browser’s local storage while your users navigate through the app, together with products added to the shopping cart. This offers a full app-like experience to your users, allowing them to continue using the app even when they don't have a network connection.

* **Web Push Notifications**. We have integrated with the OneSignal WordPress plugin, allowing you to engage users through push notifications. This is one of the most requested PWA features, proven to increase user engagement by up to 4x.

* We take pride in offering fantastic [PWACommerce](https://pwacommerce.com) **maintenance and hands-on support**. Our team of friendly progressive web app experts makes sure technology doesn't stand in your way.

* **Access to multiple app themes** that can be purchased individually or as a bundle.

* **Web Push Notifications**. We have integrated with the OneSignal WordPress plugin, allowing you to engage users through push notifications. This is one of the most requested PWA features, proven to increase user engagement by up to 4x.

Your mobile users will be able to benefit from a rich mobile buying experience on their favorite mobile device without needing to go through an App Store and install anything.

Our **tech stack for developing the mobile PWA** includes:

- [Create-React-App](https://github.com/facebook/create-react-app) for bootstrapping the project.
- [React-Semantic-UI](https://react.semantic-ui.com/introduction) (the official React integration for Semantic UI) for adding UI components such as buttons, grids, forms, etc.
- [React-Router](https://reacttraining.com/react-router/) for navigating between screens.
- [Redux](https://redux.js.org/) for managing the app state.
- [Jest](https://jestjs.io/) for unit testing.
- Eslint and the [Airbnb coding standard](https://github.com/airbnb/javascript).

We enjoy writing and maintaining this plugin. If you like it too, please rate us. But if you don't, let us know how we can improve it.

Have fun on your mobile adventures.


== Installation ==

= Simple installation for WordPress v4.8 and later =

1.  Go to the 'Plugins' / 'Add new' menu
1.	Upload pwacommerce.zip then press 'Install now'.
1.	Enjoy.

= Comprehensive setup =

A more comprehensive setup process and guide to configuration is as follows.

1. Locate your WordPress install on the file system
1. Extract the contents of `pwacommerce.zip` into `wp-content/plugins`
1. In `wp-content/plugins` you should now see a directory named `pwacommerce`
1. Login to the WordPress admin panel at `http://yoursite.com/wp-admin`
1. Go to the 'Plugins' menu.
1. Click 'Activate' for the plugin.
1. Go to the 'PWACommerce' admin panel to add your api keys and your Google Analytics ID.
1. Access your site in a mobile browser and check if the application is displayed. If the app is not loading properly, make sure you have the WooCommerce plugin installed and active, that the API is enabled and you have placed the correct keys in the PWACommerce settings.
1. You're all done!

= Testing your installation =

Ideally, use a real mobile device to access your (public) site address and check that mobile web app works correctly.

You can also download a number of mobile emulators that can run on a desktop PC and simulate mobile devices.

Please note that the mobile web app will be enabled only on supported devices: iPhones & Android smartphones. Only the following browsers are compatible: Safari, Google Chrome, Android - Native Browser, Internet Explorer 10 and Firefox (as of 2.0.2).

== Frequently Asked Questions ==

= What devices and operating systems are supported by my mobile web application?
PWAcommerce is supported on iOS and Android smartphones. Compatible browsers: Safari, Google Chrome, Android - Native Browser.

= What is the difference between my mobile PWA application and a responsive theme? =
A responsive theme is all about screen-size: it loads the same styling as the desktop view, adjusting it to fit a smaller screen. On the other hand a Progressive Web App combines the versatility of the web with the functionality of touch-enabled devices and can support native app-like features such as:

1. Offline mode. Apps load nearly instantly and are reliable, no matter what kind of network connection your user is on.
1. Web push notifications.
1.  Web app install banners give users the ability to quickly and seamlessly add your mobile app to their home screen, making it easy to launch and return to your app.
1.  Smooth animations, scrolling, and navigations keep the experience silky smooth.

= What is a progressive web app? =
Please refer to this comprehensive article about it: http://pwacommerce.com/building-e-commerce-progressive-web-app-react-woocommerce/.

= Why some 3rd party plugins are not visible on any of the app themes? =
There are almost 50,000 plugins in the WordPress.org repository. It's impossible to support all of them. [Please get in touch](https://github.com/rock-solid/pwa-theme-woocommerce/) if you want to open a feature request.


== Changelog ==

= 0.5.1 =
* Small updates

= 0.5 =
* Search products
* Infinite scroll for categories & products list
* Open product or category details at image tap
* Add 512 x 512 icon size for the app manifest
* Bug fix - shop name not wrapping in the top bar
* Bug fix - cart products maintain their order when quantity is edited
* Bug fix - cart total (sum)
* Bug fix - prices displayed in the cart are rounded to two decimals
* Upgrade WooCommerce API wrapper and Mobile Detect library to the latest versions

= 0.1 =
* Initial release


== Screenshots ==

1.Admin menu
2.App homescreen


== Roadmap ==

Our roadmap currently includes:
* Adding a complete checkout process
* Adding better variations support
* Adding product search functionality

== Repositories ==

We currently have two Github development repositories:

* [https://github.com/appticles/pwacommerce](https://github.com/rock-solid/pwacommerce) - The plugin files, same as you will find for download on WordPress.org.
* [https://github.com/appticles/pwa-theme-woocommerce](https://github.com/rock-solid/pwa-theme-woocommerce) - Development files for the Progressive Web App implemented with React, Redux and Semantic UI.
