# Implementation Plan - Standardizing Project UI Design System

Standardize the CSS across the project by defining a unified design system in `app.css` and ensuring all views (starting with `work-desk.blade.php` and `settings.blade.php`) use shared components and utility classes. This will prevent the "multicolored" look and ensure a consistent aesthetic.

## User Review Required

> [!IMPORTANT]
> I will be standardizing on the "Gemelli Premium" look which uses:
> - **Large Rounded Corners**: `rounded-[2rem]` for main containers.
> - **Bold Typography**: `font-black uppercase tracking-widest` for labels and small text.
> - **Color Palette**: Primarily Slate, Blue, and Emerald for status/actions.
> 
> Please confirm if `rounded-[2rem]` is the preferred corner radius or if you prefer the standard Tailwind `rounded-3xl`.

## Proposed Changes

### [Component Layer]

#### [MODIFY] [app.css](file:///C:/laragon/www/gemelligaragesite/resources/css/app.css)
- Add utility classes for `.ui-card`, `.ui-label`, `.ui-header-section`.
- Standardize base styles for `h1`, `p`, and `table` to match the desired bold aesthetic.

#### [MODIFY] [card.blade.php](file:///C:/laragon/www/gemelligaragesite/resources/views/components/card.blade.php)
- Update default `rounded` and `border` props to match the project standard.

#### [MODIFY] [button.blade.php](file:///C:/laragon/www/gemelligaragesite/resources/views/components/button.blade.php)
- Ensure all variants (`slate`, `blue`, `emerald`) follow the same padding, font-weight, and uppercase styling.

#### [MODIFY] [label.blade.php](file:///C:/laragon/www/gemelligaragesite/resources/views/components/form/label.blade.php)
- Standardize label appearance to `text-[10px] font-black uppercase tracking-[0.1em]`.

### [View Layer]

#### [MODIFY] [work-desk.blade.php](file:///C:/laragon/www/gemelligaragesite/resources/views/livewire/admin/work-desk/work-desk.blade.php)
- Replace manual `div` containers with `x-card`.
- Replace manual `button` tags with `x-button` where applicable.
- Replace manual label styling with `x-form.label` or a new `x-ui.label` component.
- Standardize the "POS Item" buttons and "Job Monitor" cards.

#### [MODIFY] [application-settings.blade.php](file:///C:/laragon/www/gemelligaragesite/resources/views/livewire/admin/settings/application-settings.blade.php)
- Ensure it uses the updated `x-card` and `x-button` without overriding with different rounded values.

## Verification Plan

### Manual Verification
- Inspect the **Work Desk** page to ensure all cards, buttons, and labels match the new standard.
- Inspect the **Settings** page to verify consistency.
- Check both **Light** and **Dark** modes for legibility and color consistency.
