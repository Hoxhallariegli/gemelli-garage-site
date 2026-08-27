# Improve Materials and Parts Index Views

The user wants to improve the `Materials` and `Parts` index views by making them more compact and informative, similar to the `Purchases` improvements. Based on user feedback, we will skip changing the pagination and default sorting order.

## Proposed Changes

### 1. Materials Views Layout
- **[MODIFY] [index.blade.php](file:///C:/laragon/www/gemelligaragesite/resources/views/livewire/admin/materials/index.blade.php)**:
    - Hide the ID column.
    - Add a "Përfitimi" (Margin) column.
    - Update headers for the new layout: Name, Brand, Purchase Price, Sell Price, Margin, Stock Status, Action.
    - Reduce header padding for a more compact look.
- **[MODIFY] [row.blade.php](file:///C:/laragon/www/gemelligaragesite/resources/views/livewire/admin/materials/row.blade.php)**:
    - Reduce row padding to `py-3`.
    - Display stock with a status badge (e.g., Red for low stock, Green for healthy stock).
    - Add a calculation for the profit margin percentage.
    - Remove the ID cell.

### 2. Parts Views Layout
- **[MODIFY] [index.blade.php](file:///C:/laragon/www/gemelligaragesite/resources/views/livewire/admin/parts/index.blade.php)**:
    - Hide the ID column.
    - Add a "Përfitimi" (Margin) column.
    - Update headers for the new layout: Name, Purchase Price, Sell Price, Margin, Stock Status, Action.
    - Reduce header padding.
- **[MODIFY] [row.blade.php](file:///C:/laragon/www/gemelligaragesite/resources/views/livewire/admin/parts/row.blade.php)**:
    - Reduce row padding to `py-3`.
    - Display stock with a status badge.
    - Add a calculation for the profit margin percentage.
    - Remove the ID cell.

## Verification Plan

### Manual Verification
- Navigate to the Materials and Parts pages.
- Verify that the layout is compact (`py-3`).
- Confirm the Margin (%) column shows correct calculations.
- Verify that stock levels are correctly badge-coded (e.g., < 5 might show as yellow/red).
- Confirm that the ID column is gone and the order matches the new headers.
