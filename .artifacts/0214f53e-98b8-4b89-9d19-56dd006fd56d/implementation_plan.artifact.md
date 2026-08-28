# Move Admin Login Button to Side Menu

The user wants to relocate the "Admin Login" button from the main header to the bottom of the off-canvas side menu (overlay).

## Proposed Changes

### [MODIFY] [guest.blade.php](file:///C:/laragon/www/gemelligaragesite/resources/views/components/layouts/guest.blade.php)

- Remove the "Admin Login" button from the `menu_side_area` in the header.
- Add the "Admin Login" button to the end of the `#extra-content` div in the `extra-wrap` overlay.
- Style it slightly to ensure it fits well within the side menu context (adding a spacer if necessary).

## Verification Plan

### Manual Verification
- Open the website and verify the "Admin Login" button is no longer in the header.
- Click the burger menu icon (or "btn-extra") to open the side menu.
- Verify the "Admin Login" button appears at the bottom of the side menu.
- Click the button to ensure it still redirects to the login page correctly.
