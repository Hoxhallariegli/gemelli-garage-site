# Mobile-First UX Optimization for Landing Page

Optimizing `landing-page.blade.php` to reduce scrolling, simplify the flow, and guide users ("dumb users" as per request) effectively towards the form submission, especially on mobile devices.

## Proposed Changes

### 1. Style Enhancements (Mobile-Specific)
- **Hero Section**: Reduce `min-height` on mobile from `100vh` to something like `70vh` or `80vh` to bring content higher.
- **Section Spacing**: Reduce vertical padding (`py-10`, `spacer-double`) on mobile screens.
- **Wizard Cards**: Optimize `wizard-card` padding and image sizes for mobile to fit more items on the screen.
- **Sticky CTA Bar**: Add a fixed-bottom bar for mobile that shows the "Estimated Total" and a "Continue/Submit" button, ensuring the call-to-action is always visible.

### 2. Layout Logic Improvements
- **Step Progress Bar**: Add a visual indicator of the 3 steps to show users how close they are to the end.
- **Service Selection**: Make service cards in the configurator more compact on mobile (list-like instead of big cards).
- **Navigation**: Ensure "Back" and "Next" buttons are prominent and easy to hit.

### 3. Form Optimization
- Ensure form fields have `inputmode` and `type` attributes for better mobile keyboard handling.
- Add visual focus states and clear validation hints.

## Files to Modify

#### [MODIFY] [landing-page.blade.php](file:///C:/laragon/www/gemelligaragesite/resources/views/livewire/public/landing-page.blade.php)
- Update `<style>` block with mobile media queries.
- Add Sticky Footer component for mobile.
- Refactor Step indicators and card layouts.

## Verification Plan

### Manual Verification
- Test on Mobile View (Chrome DevTools):
    - Verify Hero section height.
    - Check if Sticky Footer appears and works.
    - Verify step transitions and auto-scroll.
    - Ensure the price updates correctly in the sticky bar.
- Desktop Verification:
    - Ensure the sticky bar is hidden (or integrated differently).
    - Check overall layout consistency.
